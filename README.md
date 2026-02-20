# Joomla Autotitle Content Plugin

[![Joomla Version](https://img.shields.io/badge/Joomla!-5.x%20%2F%204.x-bd1c2a?logo=joomla&logoColor=white)](https://joomla.org)
[![License](https://img.shields.io/badge/License-GPL%20v2-blue.svg)](https://www.gnu.org/licenses/gpl-2.0.html)

A lightweight, modern Joomla content plugin created as a test task for the **Google Summer of Code (GSoC) 2026** application.

## 📌 Overview

The **Autotitle Plugin** automatically populates the title field of a new article in Joomla's administrative backend. It fetches a pre-configured default title seamlessly via AJAX without requiring a page reload.

### Features
*   **Zero-Configuration Ready**: Provides a plugin parameter to set the default text.
*   **Seamless AJAX Integration**: Intercepts the article creation form (`com_content.article`) and intelligently populates the title via `com_ajax`.
*   **Modern Joomla Architecture**: Built strictly adhering to the latest Joomla 4/5 structure, utilizing `SubscriberInterface` and dependency injection (`services/provider.php`).
*   **Minimalist & Performant**: Contains no bloat, keeping the codebase extremely lean and clean.

## 🚀 Installation & Usage

1. **Download**: Click **Code > Download ZIP** from this GitHub repository to download the installable package.
2. **Install**: In your Joomla Administrator panel, navigate to **System > Install > Extensions** and upload the downloaded ZIP file.
3. **Enable & Configure**:
    * Go to **System > Manage > Plugins**.
    * Search for **Content - Autotitle**.
    * Click on the plugin to open its settings.
    * Enter your desired text in the **Default Title Text** field.
    * Set the plugin Status to **Enabled** and click **Save & Close**.
4. **Test**: Navigate to **Content > Articles > + New**. The title field will automatically be filled with your configured text!

## 🏗️ Architecture

This plugin demonstrates modern Joomla development practices:
*   `autotitle.xml`: The extension manifest file defining the plugin parameters and structure.
*   `services/provider.php`: Uses Joomla's Dependency Injection (DI) container to instantiate the plugin.
*   `src/Extension/Autotitle.php`: The core logic, implementing `SubscriberInterface` to listen for `onContentPrepareForm` (to inject JS) and `onAjaxAutotitle` (to return the configured string).
*   `media/js/script.js`: Native vanilla JavaScript module that fetches the title from `com_ajax` and injects it into the DOM.

---
*Developed by [Adarsh Dubey](https://github.com/adarshdubey03) for GSoC 2026.*
