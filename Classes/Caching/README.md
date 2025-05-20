# Caching in EXT:schema

We use a runtime cache for storing the generated markup temporarily. The
event listener "MarkupInCacheSetter" is called to persist the markup in
the cache. The event listener is only called if the page should be cached.

Frontend request with deactivated/unavailable admin panel:
- SchemaMarkupInjection (stores markup in runtime cache)
- StoreMarkupInPersistentCache (persists markup, by default in database)

Frontend request with activated admin panel (first hit):
- SchemaMarkupInjection
- SchemaModule
- TypesInformation
- StoreMarkupInPersistentCache

Frontend request with activated admin panel (subsequent hit):
- SchemaModule
- TypesInformation

As we see in "Frontend request with activated admin panel (first hit)", the
admin panel is called before the cache is written, therefore the usage of
the runtime cache to pass the information.
