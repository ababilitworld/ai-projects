# AIT Elite v4.4 Reliability Upgrade

## Release status

AIT Elite v4.4 is **structurally improved but currently conditional** on the supplied OHLC history.

- Model reliability: **CONDITIONAL**
- Rolling calibration health: **Caution**
- Strong Buy trust: **Conditional**
- New-entry decision gate: **CONFIRMATION ONLY**

This is intentional. The upgraded model has substantially better historical and holdout evidence, but the latest short regime is weak and the date-clustered 95% uncertainty range still touches zero. The scanner therefore does not claim unrestricted reliability or permit automatic `BUY NOW` decisions.

## Verified result on the supplied storage

Validation universe: the 103 securities in the CSE Shariah Index revision effective 3 June 2026 that were present in the supplied DSE archive.

| Measure | v4.4 result |
| --- | ---: |
| Reconstructed trading dates | 221 |
| Base signal-date observations | 22,416 |
| Exact 9-market-day evaluable observations | 21,344 |
| Advanced Rank quality, all history | 71.0 · Strong |
| Advanced Rank quality, final holdout | 92.6 · Pass |
| Strong Buy 9D excess | +0.96% |
| Strong Buy 20D excess | +1.73% |
| Strong Buy 9D excess, final holdout | +0.82% |
| Strong Buy 20D excess, final holdout | +2.70% |
| Strong Buy time consistency | 73% · 8/11 eligible blocks |
| Strong Buy 9D date-clustered 95% range | −0.04% to +1.94% |

Excess return means the stock return minus the contemporaneous equal-weight return of the active validation universe. It is not the same as raw return and is not a promise of future profit.

## Chronological validation

The model uses ordered dates—never shuffled observations. The Advanced Rank rule was assessed in development and validation periods first. The Strong Buy cutoff was frozen at the per-date Advanced Rank top 8% before the final 20% holdout was inspected.

| Period | Dates | Rank quality | Top-10% 9D excess | Strong Buy 9D excess | Result |
| --- | ---: | ---: | ---: | ---: | --- |
| Development 60% | 132 | 61.3 · Good | +0.84% | +0.96% | Pass |
| Validation 20% | 44 | 84.9 · Strong | +1.21% | +1.05% | Pass |
| Final holdout 20% | 45 | 92.6 · Strong | +0.48% | +0.82% | Pass |

The final holdout has now been consumed. Further threshold tuning against these same dates would contaminate it and create overfitting. Promotion from `CONDITIONAL` to `RELIABLE` must come from fresh future OHLC observations, not repeated fitting to this archive.

## What changed

1. **Walk-forward-validated ranking** — Advanced Score now drives the cross-sectional rank. The prior Elite setup score remains visible as a separate entry/calibration diagnostic.
2. **Frozen final rank signals** — Strong Buy is top 8%, Buy is 8–20%, Watch is 20–80%, and Avoid is bottom 20% by per-date Advanced Rank.
3. **Action remains separate from setup** — entry quality, liquidity, volatility, support, breakout state, portfolio state and the performance safety gate still determine `What to Do`. A Strong Buy setup can correctly produce `WAIT`.
4. **Exact trading-date horizons** — 1D, 3D, 6D, 9D, 15D and 20D returns use common market trading dates. A missing or zero close on the exact entry/target date is excluded instead of being silently replaced by an earlier or later price.
5. **Leakage-safe reconstruction** — every historical calculation is cut off at its replay date. Future data is used only for subsequent return, MFE and MAE evaluation.
6. **Stronger cache invalidation** — the complete OHLC history is fingerprinted. Incremental reuse is allowed only when the cached historical prefix matches exactly.
7. **Chronological holdout monitor** — development, validation and untouched final-holdout tables are now built into the performance monitor.
8. **Uncertainty and sample clarity** — the monitor separates base observations from 9D-evaluable observations and reports a Newey–West date-clustered diagnostic interval for Strong Buy.
9. **Performance improvements** — snapshot calculations, positive-price series and date indexes are cached; Advanced history is calculated once per snapshot rather than once per stock.

## Automatic safety rules

`RELIABLE` requires all of the following:

- Advanced Rank passes development, validation and final holdout;
- all-history Strong Buy evidence is positive and trusted;
- final-holdout Strong Buy has at least 30 evaluable samples and positive 9D excess;
- Strong Buy is consistent across at least 65% of eligible 20-date blocks; and
- the date-clustered 95% lower bound is above zero.

The new-entry gate becomes `OPEN` only when reliability is `RELIABLE`, rolling health is `Healthy`, current Strong Buy trust is `Trusted`, and time consistency is `Consistent`. Otherwise it remains `CONFIRMATION ONLY` or `LOCKED`.

## How monitoring updates

Open **AIT Elite Performance Monitor** after adding or changing OHLC data. v4.4 fingerprints the full archive, rebuilds only when necessary, recomputes exact forward horizons and refreshes the stored model state used by the decision scanner.

This software is a decision-support and validation tool, not financial advice or a guarantee of future returns.
