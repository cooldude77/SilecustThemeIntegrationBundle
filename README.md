In order to use themes in Silecust Web App, you will need to create  

`silecust_theme_management.yaml` in packages directory and include following code in it

```
silecust_theme_management:
  theme_integration_active: true
  theme_bundles:
    SilecustThemeDefault:
        bundle_name: "@SilecustDefaultThemeBundle"
        active: true
    abc: ~
```
