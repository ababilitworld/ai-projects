# AIT Elite v4.3 Decision Validation

- Keeps v4.2 scanner scoring weights unchanged to avoid performance chasing/overfitting.
- Renames old Signal Validation to Legacy / Raw Signal Validation and marks it diagnostic-only.
- Adds Strong Buy comparative validation versus Buy, Watch, Avoid, and all non-Strong-Buy observations.
- Adds non-overlapping 20-trading-date Strong Buy time-consistency analysis.
- Adds an explicit Decision Gate: OPEN / CONFIRMATION ONLY / LOCKED.
- BUY NOW now requires Healthy model health, Trusted Strong Buy evidence, Consistent time evidence, an OPEN decision gate, and the existing stock-specific entry/short/mid gates.
- Generic percentile ranking remains visible as a diagnostic but is no longer presented as the primary actionable-signal test.
