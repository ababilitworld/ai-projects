# AIT Elite v4.1 Calibration Report

## Method

- Replayed the Elite scanner in Chromium over the bundled one-year OHLC archive.
- Calibration universe: the 112-stock CSE Shariah watch list used by the existing performance monitor.
- Historical feature rows were generated from information available at each historical cutoff date.
- Forward validation excludes rows with Close <= 0 because those are non-trading observations, not valid transaction prices.
- Candidate fitted scoring models were evaluated on later unseen dates. A fitted model that improved in-sample results but failed the final holdout was rejected.

## Accepted finding

The existing Elite v4 setup/final-signal logic is more stable than the attempted regression replacement after the zero-price validation correction. Recent evidence is regime-dependent rather than a clear structural failure.

Corrected 9D excess by Final Signal:

- Recent 100D: Strong Buy +1.315%, Buy +0.419%, Watch +0.122%, Avoid -0.481%.
- Recent 60D: Strong Buy +0.360%, Buy +0.471%, Watch +0.273%, Avoid -0.763%.
- Recent 40D remains weak/mixed, so BUY NOW should remain locked under Caution until recent performance recovers.

## v4.1 changes

1. Performance validation ignores Close <= 0 rows in entry and forward-return calculations.
2. Adds a 100D regime-confirmation window.
3. 20D/40D weakness causes Caution rather than declaring the model structurally broken when 60D/100D evidence remains acceptable.
4. Recalibration Required now needs deterioration to persist through medium/longer confirmation windows.
5. BUY NOW still requires a Healthy model state; the safety gate was not weakened.
6. Model/performance cache namespaces were bumped so v4.1 rebuilds cleanly.

## Interpretation

Caution means the underlying scanner has usable medium-window evidence but the latest market regime is not strong enough to authorize a fresh BUY NOW signal. This is intentionally different from Degraded/Recalibration Required, which indicates broader persistent model failure.
