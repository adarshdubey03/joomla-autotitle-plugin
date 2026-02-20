# Joomla! GSoC 2026 Test Task: Autotitle Content Plugin

![Joomla Version](https://img.shields.io/badge/Joomla!-6.x-blue?style=flat-square&logo=joomla)
![License](https://img.shields.io/badge/License-GPLv2-green.svg?style=flat-square)

This repository contains my solution for the **Google Summer of Code (GSoC) 2026 Test Task** for the Joomla! Project. The objective of this task is to create a modern, elegant content plugin that automatically fills the title of a newly created article by fetching a predefined parameter value asynchronously via `com_ajax`.

## 🎯 Task Requirements Checklist
This plugin successfully implements all the requirements requested by the mentors:

- [x] **Textfield Parameter:** The plugin configuration provides a textfield parameter (`default_text`) to input the default title string.
- [x] **Form View Integration:** The plugin effectively hooks into `onContentPrepareForm` and only loads assets on the `com_content.article` form view.
- [x] **AJAX Retrieval:** When creating a strictly *new* article, the plugin issues an asynchronous request to Joomla's `com_ajax` component. The parameter value is retrieved and dynamically set as the value of the title field `jform_title` without reloading the page.
- [x] **Modern Joomla Architecture:** The codebase strictly adheres to the newest Joomla! 6 extension architecture, utilizing:
  - Dependency Injection (DI) via `provider.php`
  - PHP Namespaces (`Adarsh\Plugin\Content\Autotitle`)
  - Event Subscription (`SubscriberInterface`)
  - The `WebAssetManager` API for injecting JavaScript assets.
- [x] **Existing Joomla Methods:** Uses native core APIs (`Factory`, `WebAssetManager`, `com_ajax`) instead of bypassing system behavior with custom routing or ad-hoc queries.

## 📂 File Structure

```text
plg_content_autotitle/
├── autotitle.xml         # Extension manifest & configuration parameters
├── services/
│   └── provider.php      # Dependency Injection (DI) Container Registration
├── src/
│   └── Extension/
│       └── Autotitle.php # Main Plugin Class & Event Subscribers
└── media/
    └── js/
        └── script.js     # ES6 module handling the com_ajax fetch request
```

## ⚙️ How It Works Under the Hood

1. **Initialization (`onContentPrepareForm`)**: 
   When the article form is loaded, the plugin verifies it is the `com_content.article` context and strictly a creation instance (`id = 0`). It registers a small inline script containing a CSRF token & dynamic AJAX URL via `addScriptDeclaration`, and queues the main `.js` file via the `WebAssetManager`.
2. **The Client-Side Request (`script.js`)**:
   Once the DOM is loaded, the JavaScript executes a lightweight `fetch` request directed to `index.php?option=com_ajax&plugin=autotitle&group=content&format=json`.
3. **The AJAX Resolution (`onAjaxAutotitle`)**:
   The `com_ajax` component triggers the `onAjaxAutotitle` event within the plugin. The plugin fetches the stored component parameter (`default_text`) and returns the string.
4. **DOM Update**:
   The JavaScript receives the JSON response and assigns the fetched string directly to the Article Title input field (`#jform_title`).

## 🚀 Installation & Testing

You can easily download and install this plugin to evaluate its functionality:

1. Click the green **Code** button at the top of this repository.
2. Select **Download ZIP**.
3. Log into your Joomla! Administrator Dashboard.
4. Navigate to **System > Install > Extensions**.
5. Upload the downloaded ZIP file.
6. Navigate to **System > Manage > Plugins** and search for `Autotitle`.
7. **Enable the plugin**, open it, and type your desired default title into the `Default Title Text` parameter field. Save & Close.
8. Navigate to **Content > Articles > New**. Watch the title field automatically populate!
