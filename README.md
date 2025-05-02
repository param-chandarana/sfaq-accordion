# Simple FAQ Accordion

A lightweight WordPress plugin that provides an accessible FAQ accordion via a shortcode. Features include toggle icons, default-open capability, external assets, and a settings page for customizing colors and icons.

---

## Table of Contents

- [Simple FAQ Accordion](#simple-faq-accordion)
  - [Table of Contents](#table-of-contents)
  - [Overview](#overview)
  - [Installation](#installation)
  - [Usage](#usage)
  - [Settings](#settings)
  - [File Structure](#file-structure)
  - [Change Log](#change-log)

---

## Overview

The **Simple FAQ Accordion** plugin allows you to display FAQs as collapsible accordion items using the `[faq]` shortcode. Key features:

* Toggle icons (`+`/`–`) for open/close states.
* Shortcode attribute `open="true"` to default an item as expanded.
* External CSS and JS files for easy theming.
* Admin settings page to customize:

  * Title background color
  * Content background color
  * Icons for open/closed states

---

## Installation

1. Upload the `sfq-accordion` folder to your WordPress `wp-content/plugins/` directory.
2. Activate the plugin through **Plugins » Installed Plugins** in the WordPress admin.
3. (Optional) Navigate to **Settings » FAQ Accordion** to customize colors and icons.

---

## Usage

Add the `[faq]` shortcode anywhere in your posts or pages:

```html
[faq title="What is this plugin?"]
This plugin displays an accordion item with a title and content.
[/faq]
```

**Attributes**:

* `title` (string) — The question or heading of the FAQ.
* `open` (true|false) — Whether the item should be expanded by default (defaults to `false`).

Example with default-open:

```html
[faq title="Why choose us?" open="true"]
Because we care about code quality and accessibility.
[/faq]
```

---

## Settings

Navigate to **Settings » FAQ Accordion** to customize:

| Setting                  | Description                                    | Default   |
| ------------------------ | ---------------------------------------------- | --------- |
| Title Background Color   | Hex color for the FAQ title background         | `#f1f1f1` |
| Content Background Color | Hex color for the FAQ content background       | `#ffffff` |
| Closed Icon              | Character or HTML entity for closed state icon | `+`       |
| Open Icon                | Character or HTML entity for open state icon   | `–`       |

Save changes to apply across all FAQ items.

---

## File Structure

```
sfq-accordion/
├── css/
│   └── accordion.css      # Styles for accordion layout
├── js/
│   └── accordion.js       # Script for toggle behavior
├── includes/
│   └── settings.php       # Admin settings page and registration
└── sfq-accordion.php      # Main plugin file (shortcode handler, asset enqueue)
```

* **sfq-accordion.php**: Defines plugin headers, enqueues assets, and registers the `[faq]` shortcode.
* **css/accordion.css**: Contains CSS classes for `.sfq-accordion-item`, `.sfq-accordion-title`, `.sfq-icon`, and `.sfq-accordion-content`.
* **js/accordion.js**: Handles click events to toggle active state, swap icons, and show/hide content.
* **includes/settings.php**: Implements the Settings API to allow customization of colors and icons via the WP admin.

---

## Change Log

* **1.0.0**: Initial release with inline CSS/JS and basic shortcode.
* **1.1.0**: Added toggle icons and `open` shortcode attribute.
* **1.2.0**: Extracted assets to external files and implemented global settings page.
* **1.3.0**: Implemented global settings page to change colors and toggle icons.