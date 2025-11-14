# Dynamic Menu Logo Switcher

**Contributors:** Deeb Al Turk  
**Tags:** logo, menu, branding, dynamic, switcher, navigation  
**Requires at least:** 5.0  
**Tested up to:** 6.4  
**Requires PHP:** 7.4  
**Stable tag:** 2.0.0  
**License:** Free for everyone

Automatically switch website logos based on active navigation menus. Perfect for multi-brand sites, different sections, or dynamic branding needs.

## Description

Dynamic Menu Logo Switcher allows you to set different logos for different navigation menus on your WordPress site. The plugin automatically detects which menu is being displayed on each page and switches the logo accordingly.

### Key Features

🎯 **Smart Menu Detection** - Automatically identifies active menus on each page  
🖼️ **Media Library Integration** - Easy logo upload using WordPress media library  
👀 **Live Preview** - See logo previews before saving  
📊 **Overview Dashboard** - Manage all menu logos from one place  
🎨 **Theme Compatible** - Works with any WordPress theme  
⚡ **Lightweight** - Minimal performance impact  
🔧 **Easy Setup** - No coding required  

### Perfect For

- **Multi-brand websites** with different sections
- **Corporate sites** with various divisions
- **Portfolio sites** with different project categories  
- **E-commerce stores** with multiple product lines
- **Agency websites** showcasing different services
- **Educational sites** with different departments

### How It Works

1. **Create Your Menus** - Set up different navigation menus in WordPress
2. **Assign Logos** - Upload and assign custom logos to each menu
3. **Automatic Switching** - The plugin detects active menus and switches logos automatically
4. **Seamless Experience** - Visitors see the appropriate logo for each section

## Installation

### Automatic Installation

1. Go to your WordPress admin dashboard
2. Navigate to **Plugins > Add New**
3. Search for "Dynamic Menu Logo Switcher"
4. Click **Install Now** and then **Activate**

### Manual Installation

1. Download the plugin zip file
2. Go to **Plugins > Add New > Upload Plugin**
3. Choose the zip file and click **Install Now**
4. Activate the plugin

### From GitHub

1. Download or clone this repository
2. Upload the `dynamic-menu-logo-switcher` folder to `/wp-content/plugins/`
3. Activate the plugin through the WordPress admin

## Usage

### Quick Start Guide

1. **Access Settings**
   - Go to **Settings > Menu Logos** in your WordPress admin

2. **Select a Menu**
   - Choose the menu you want to configure from the dropdown

3. **Upload Logo**
   - Click "Choose Image" to select a logo from your media library
   - Or enter a direct URL to your logo image

4. **Save Settings**
   - Click "Save Logo" to apply your changes

5. **Repeat for Other Menus**
   - Configure logos for all your different menus

### Advanced Configuration

#### Menu Structure Requirements
The plugin works by detecting menu elements with IDs following WordPress conventions:
- Menu ID format: `#menu-{menu-slug}`
- Example: `#menu-main-navigation`, `#menu-footer-menu`

#### Logo Placement
The plugin targets logo images using the CSS selector `.logo img`. Most themes follow this convention, but you may need to adjust your theme if logos aren't switching.

## Screenshots

1. **Admin Dashboard** - Overview of all configured menu logos
2. **Logo Configuration** - Easy setup with media library integration
3. **Live Preview** - See how your logo will look before saving
4. **Menu Selection** - Simple dropdown to choose which menu to configure

## Frequently Asked Questions

### Q: Will this work with my theme?
**A:** The plugin works with most WordPress themes that follow standard conventions for logo placement. It targets `.logo img` elements by default.

### Q: Can I use different logo sizes for different menus?
**A:** Yes! Each menu can have its own logo with different dimensions. The plugin preserves the original styling of your theme.

### Q: What image formats are supported?
**A:** All standard web image formats are supported: JPG, PNG, GIF, SVG, and WebP.

### Q: Does this affect site performance?
**A:** The plugin is lightweight and only loads a small JavaScript snippet on the frontend. Performance impact is minimal.

### Q: Can I remove a logo once it's set?
**A:** Yes, there's a "Remove Logo" button for each configured menu in the admin panel.

### Q: What happens if no custom logo is set?
**A:** The plugin will fall back to your theme's default logo, ensuring your site always displays a logo.

## Technical Details

### System Requirements
- WordPress 5.0 or higher
- PHP 7.4 or higher
- Modern web browser with JavaScript enabled

### File Structure
```
dynamic-menu-logo-switcher/
├── custom-logo-based-menu.php (Main plugin file)
├── README.md (This file)
└── assets/ (Future: Screenshots and assets)
```

### Hooks and Filters
The plugin uses standard WordPress hooks:
- `admin_menu` - Adds admin menu page
- `admin_init` - Handles form submissions
- `wp_head` - Outputs frontend JavaScript
- `admin_enqueue_scripts` - Loads media library scripts

## Changelog

### 2.0.0 (Current)
- **New:** Enhanced admin interface with overview dashboard
- **New:** WordPress media library integration
- **New:** Live logo preview functionality
- **New:** Remove logo functionality
- **Improved:** Better error handling and user feedback
- **Improved:** Professional admin styling
- **Fixed:** Dynamic menu detection for all menu types

### 1.0.0
- Initial release
- Basic menu logo switching functionality
- Simple admin interface

## Support

### Getting Help
- **Documentation:** Check this README for common solutions
- **GitHub Issues:** Report bugs or request features
- **WordPress Forums:** Community support available

### Contributing
Contributions are welcome! Please:
1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## License

This plugin is **completely free** and open for everyone to use, modify, and distribute without any restrictions. Feel free to use it in personal or commercial projects!


## Credits

Developed by **Deeb Al Turk**  
Plugin inspired by the need for dynamic branding solutions in modern WordPress sites.

---

**Like this plugin?** ⭐ Star it on GitHub and leave a review on WordPress.org!
