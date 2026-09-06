(function (root) {
  "use strict";

  /**
   * Maintains lightweight download manifests for each watch list.
   *
   * OHLC and fundamental records remain normalized by trading code in their
   * existing stores. The manifest records which watch list initiated each
   * operation and derives current coverage from those shared symbol stores,
   * avoiding large duplicated histories when lists contain the same code.
   */
  class AITWatchListDownloadCache {
    static VERSION = 1;

    static normalizeCode(value) {
      return String(value ?? "")
        .trim()
        .toUpperCase()
        .replace(/[^A-Z0-9().&_-]/g, "");
    }

    static normalizeCodes(values) {
      return [...new Set(
        (Array.isArray(values) ? values : [])
          .map((value) => this.normalizeCode(value))
          .filter(Boolean)
      )];
    }

    static signature(list = {}) {
      return `${String(list?.id ?? "none")}|${this.normalizeCodes(list?.codes).join("|")}`;
    }

    static emptyState() {
      return { version: this.VERSION, lists: {} };
    }

    static normalizeOperation(operation) {
      if (!operation || typeof operation !== "object" || Array.isArray(operation)) return null;

      return {
        ...operation,
        requestedCodes: this.normalizeCodes(operation.requestedCodes),
        matchedCodes: this.normalizeCodes(operation.matchedCodes),
        missingCodes: this.normalizeCodes(operation.missingCodes)
      };
    }

    static normalizeState(value) {
      const normalized = this.emptyState();
      const source = value && typeof value === "object" && !Array.isArray(value) ? value : {};
      const lists = source.lists && typeof source.lists === "object" && !Array.isArray(source.lists)
        ? source.lists
        : {};

      Object.entries(lists).forEach(([rawId, manifest]) => {
        if (!manifest || typeof manifest !== "object" || Array.isArray(manifest)) return;
        const listId = String(manifest.listId ?? rawId).trim();
        if (!listId) return;

        const fundamentals = manifest.fundamentals && typeof manifest.fundamentals === "object"
          ? manifest.fundamentals
          : {};

        normalized.lists[listId] = {
          listId,
          listName: String(manifest.listName ?? "Watch List"),
          codes: this.normalizeCodes(manifest.codes),
          codeSignature: String(manifest.codeSignature ?? ""),
          lastActivatedAt: manifest.lastActivatedAt || null,
          ohlc: this.normalizeOperation(manifest.ohlc),
          fundamentals: {
            dse: this.normalizeOperation(fundamentals.dse),
            amarstock: this.normalizeOperation(fundamentals.amarstock)
          }
        };
      });

      return normalized;
    }

    constructor(state = {}) {
      if (!state || typeof state !== "object" || Array.isArray(state)) {
        throw new TypeError("A dashboard state object is required.");
      }

      this.state = state;
      this.state.watchListDownloads = AITWatchListDownloadCache.normalizeState(state.watchListDownloads);
      this.reconcile(state.watchLists);
    }

    registry() {
      return this.state.watchListDownloads.lists;
    }

    reconcile(watchLists = []) {
      const lists = Array.isArray(watchLists) ? watchLists : [];
      const validIds = new Set(lists.map((list) => String(list?.id ?? "").trim()).filter(Boolean));

      Object.keys(this.registry()).forEach((listId) => {
        if (!validIds.has(listId)) delete this.registry()[listId];
      });

      lists.forEach((list) => {
        const existing = this.manifest(list, false);
        if (!existing) return;
        existing.listName = String(list?.name ?? existing.listName ?? "Watch List");
        existing.codes = AITWatchListDownloadCache.normalizeCodes(list?.codes);
        existing.codeSignature = AITWatchListDownloadCache.signature(list);
      });

      return this.state.watchListDownloads;
    }

    manifest(list, create = true) {
      const listId = String(list?.id ?? "").trim();
      if (!listId) return null;

      if (!this.registry()[listId] && create) {
        this.registry()[listId] = {
          listId,
          listName: String(list?.name ?? "Watch List"),
          codes: AITWatchListDownloadCache.normalizeCodes(list?.codes),
          codeSignature: AITWatchListDownloadCache.signature(list),
          lastActivatedAt: null,
          ohlc: null,
          fundamentals: { dse: null, amarstock: null }
        };
      }

      const manifest = this.registry()[listId] || null;
      if (manifest) {
        manifest.listName = String(list?.name ?? manifest.listName ?? "Watch List");
        manifest.codes = AITWatchListDownloadCache.normalizeCodes(list?.codes);
        manifest.codeSignature = AITWatchListDownloadCache.signature(list);
      }

      return manifest;
    }

    touch(list, timestamp = new Date().toISOString()) {
      const manifest = this.manifest(list);
      if (manifest) manifest.lastActivatedAt = timestamp;
      return manifest;
    }

    remove(listId) {
      delete this.registry()[String(listId ?? "")];
    }

    recordOhlc(list, details = {}) {
      const manifest = this.manifest(list);
      if (!manifest) return null;

      const previous = manifest.ohlc || {};
      const timestamp = String(details.timestamp || new Date().toISOString());
      const start = String(details.start || "");
      const end = String(details.end || "");
      const rangeStart = [previous.rangeStart, start].filter(Boolean).sort()[0] || null;
      const rangeEnd = [previous.rangeEnd, end].filter(Boolean).sort().at(-1) || null;
      const noUpdate = details.noUpdate === true;

      manifest.ohlc = {
        ...previous,
        requestedCodes: AITWatchListDownloadCache.normalizeCodes(details.requestedCodes ?? list?.codes),
        matchedCodes: AITWatchListDownloadCache.normalizeCodes(details.matchedCodes),
        missingCodes: AITWatchListDownloadCache.normalizeCodes(details.missingCodes),
        rangeStart,
        rangeEnd,
        lastMode: String(details.mode || previous.lastMode || "download"),
        lastSource: String(details.source || previous.lastSource || "DSE"),
        lastOperationRecords: Math.max(0, Number(details.records) || 0),
        lastCheckedAt: timestamp,
        lastDownloadedAt: noUpdate ? previous.lastDownloadedAt || null : timestamp,
        lastResult: noUpdate ? "up-to-date" : "downloaded"
      };

      return manifest.ohlc;
    }

    recordFundamentals(list, source, details = {}) {
      const manifest = this.manifest(list);
      if (!manifest) return null;

      const key = String(source || "").toLowerCase() === "amarstock" ? "amarstock" : "dse";
      const previous = manifest.fundamentals[key] || {};
      manifest.fundamentals[key] = {
        ...previous,
        requestedCodes: AITWatchListDownloadCache.normalizeCodes(details.requestedCodes ?? list?.codes),
        matchedCodes: AITWatchListDownloadCache.normalizeCodes(details.matchedCodes),
        missingCodes: AITWatchListDownloadCache.normalizeCodes(details.missingCodes),
        saved: Math.max(0, Number(details.saved) || 0),
        failed: Math.max(0, Number(details.failed) || 0),
        lastDownloadedAt: String(details.timestamp || new Date().toISOString())
      };

      return manifest.fundamentals[key];
    }

    clearOhlc() {
      Object.values(this.registry()).forEach((manifest) => {
        manifest.ohlc = null;
      });
    }

    ohlcCoverage(list, history = {}) {
      const codes = AITWatchListDownloadCache.normalizeCodes(list?.codes);
      const missingCodes = [];
      const coveredCodes = [];
      const latestByCode = {};
      let recordCount = 0;
      let rangeStart = "";
      let rangeEnd = "";

      codes.forEach((code) => {
        const rows = Array.isArray(history?.[code]) ? history[code] : [];
        const dates = rows
          .map((row) => String(row?.date || "").slice(0, 10))
          .filter((date) => /^\d{4}-\d{2}-\d{2}$/.test(date))
          .sort();

        recordCount += rows.length;
        if (!dates.length) {
          missingCodes.push(code);
          return;
        }

        coveredCodes.push(code);
        latestByCode[code] = dates.at(-1);
        if (!rangeStart || dates[0] < rangeStart) rangeStart = dates[0];
        if (dates.at(-1) > rangeEnd) rangeEnd = dates.at(-1);
      });

      const commonLatestDate = missingCodes.length || !coveredCodes.length
        ? ""
        : coveredCodes.map((code) => latestByCode[code]).sort()[0];

      return {
        requestedCodes: codes,
        coveredCodes,
        missingCodes,
        codeCount: coveredCodes.length,
        recordCount,
        rangeStart,
        rangeEnd,
        latestByCode,
        commonLatestDate,
        complete: codes.length > 0 && missingCodes.length === 0
      };
    }

    fundamentalCoverage(list, fundamentals = {}) {
      const codes = AITWatchListDownloadCache.normalizeCodes(list?.codes);
      const hasValue = (value) => value !== null && value !== undefined && value !== "";
      let codeCount = 0;
      let dseCount = 0;
      let amarstockCount = 0;

      codes.forEach((code) => {
        const compact = code.replace(/[^A-Z0-9]/g, "");
        const row = fundamentals?.[code] || fundamentals?.[compact];
        if (!row || typeof row !== "object") return;
        codeCount++;

        if ([row.category, row.businessSegment, row.sector, row.industry, row.yearEnd, row.financialYearEnd, row.lastAgmDate, row.lastAgm].some(hasValue)) {
          dseCount++;
        }
        if ([row.peRatio, row.eps, row.priceNav, row.freeFloat, row.beta, row.dividendYield].some(hasValue)) {
          amarstockCount++;
        }
      });

      return { requestedCodes: codes, codeCount, dseCount, amarstockCount };
    }

    summary(list, history = {}, fundamentals = {}) {
      const manifest = this.manifest(list, false);
      const ohlc = this.ohlcCoverage(list, history);
      const fundamental = this.fundamentalCoverage(list, fundamentals);
      const activityDates = [
        manifest?.ohlc?.lastCheckedAt,
        manifest?.fundamentals?.dse?.lastDownloadedAt,
        manifest?.fundamentals?.amarstock?.lastDownloadedAt
      ].filter(Boolean).sort();

      return {
        listId: String(list?.id ?? ""),
        listName: String(list?.name ?? "Watch List"),
        codeSignature: AITWatchListDownloadCache.signature(list),
        codeCount: AITWatchListDownloadCache.normalizeCodes(list?.codes).length,
        ohlc,
        fundamentals: fundamental,
        manifest,
        lastActivityAt: activityDates.at(-1) || null,
        hasCachedData: ohlc.recordCount > 0 || fundamental.codeCount > 0
      };
    }
  }

  root.AITWatchListDownloadCache = AITWatchListDownloadCache;

  if (typeof module === "object" && module.exports) {
    module.exports = { AITWatchListDownloadCache };
  }
})(typeof globalThis !== "undefined" ? globalThis : window);
