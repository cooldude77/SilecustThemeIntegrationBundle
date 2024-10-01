In order to use themes in Silecust Web App, you will need to create

`silecust_theme_integration.yaml` in packages directory and include following code in it

```
silecust_theme_integration:
  theme_integration_active: true
  theme_bundles:
    SilecustThemeDefault:
        bundle_name: "@SilecustDefaultThemeBundle"
        active: true
    abc: ~
```
