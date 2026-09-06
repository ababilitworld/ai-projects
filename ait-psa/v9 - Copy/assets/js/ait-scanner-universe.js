(function (root) {
  "use strict";

  /**
   * Resolves the symbol universe used by AIT scanners.
   *
   * Scanner calculations intentionally use only the currently active watch
   * list. Broader symbol consumers (for example Explorer and Portfolio symbol
   * selectors) can continue to request the complete locally known universe.
   */
  class AITScannerUniverse {
    static normalizeCode(value) {
      return String(value ?? "").trim().toUpperCase();
    }

    static normalizeCodes(values, { sort = false } = {}) {
      const normalized = [...new Set(
        (Array.isArray(values) ? values : [])
          .map((value) => this.normalizeCode(value))
          .filter(Boolean)
      )];

      return sort ? normalized.sort((a, b) => a.localeCompare(b)) : normalized;
    }

    static resolveActive(context = {}) {
      const state = context.state && typeof context.state === "object" ? context.state : {};
      const lists = Array.isArray(context.lists)
        ? context.lists
        : Array.isArray(state.watchLists)
          ? state.watchLists
          : [];

      if (context.active && typeof context.active === "object") return context.active;
      return lists.find((list) => list?.id === state.activeId) || lists[0] || {};
    }

    static activeCodes(context = {}) {
      const active = this.resolveActive(context);
      return this.normalizeCodes(active?.codes);
    }

    static allCodes(context = {}) {
      const state = context.state && typeof context.state === "object" ? context.state : {};
      const history = context.history && typeof context.history === "object"
        ? context.history
        : state.history && typeof state.history === "object"
          ? state.history
          : {};
      const lists = Array.isArray(context.lists)
        ? context.lists
        : Array.isArray(state.watchLists)
          ? state.watchLists
          : [];
      const mother = Array.isArray(state.motherCodes)
        ? state.motherCodes
        : Object.keys(state.motherCodes || {});

      return this.normalizeCodes([
        ...mother,
        ...this.activeCodes(context),
        ...lists.flatMap((list) => Array.isArray(list?.codes) ? list.codes : []),
        ...Object.keys(history)
      ], { sort: true });
    }

    static activeHistory(context = {}) {
      const state = context.state && typeof context.state === "object" ? context.state : {};
      const history = context.history && typeof context.history === "object"
        ? context.history
        : state.history && typeof state.history === "object"
          ? state.history
          : {};

      return Object.fromEntries(
        this.activeCodes(context).map((code) => [code, Array.isArray(history[code]) ? history[code] : []])
      );
    }

    static signature(context = {}) {
      const active = this.resolveActive(context);
      const id = String(active?.id ?? context?.state?.activeId ?? "none");
      return `${id}|${this.activeCodes({ ...context, active }).join("|")}`;
    }
  }

  root.AITScannerUniverse = AITScannerUniverse;

  if (typeof module === "object" && module.exports) {
    module.exports = { AITScannerUniverse };
  }
})(typeof globalThis !== "undefined" ? globalThis : window);
