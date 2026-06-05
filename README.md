⚠️ **IMPORTANT WARNING**: All modifications in this repository were performed using Artificial Intelligence (AI). Therefore, it is highly likely that you will find insecure, inefficient, or unoptimized code in these changes. Use this code at your own risk in production environments.

---

# BitView (Modified Source Code)

This repository contains the source code of **BitView**, originally published by **copymeows**, which has been modified and updated to adapt to modern development environments and fix legacy bugs.

## Differences from the Original Code

Unlike the base code, the following changes and restorations have been made in this modified version:

- **Restored Pages**: Restored the functionality of the **blog** and **inbox** pages.
- **checkUsername Function**: Restored and fixed the `checkUsername` validation script for user registration.
- **New Options in the Admin Panel**:
  - Option to enable/disable **video conversion via FFmpeg** ("FFmpeg Video Conversion").
  - Option to **allow custom thumbnails for all users** ("Allow Custom Thumbnails (all users)").
- **Added Configuration Files**:
  - `.htaccess` file for URL rewriting.
  - `.gitignore` file to exclude unnecessary files from Git.
- **Environment Variables Support (`.env`)**: Integrated the `vlucas/phpdotenv` library to load sensitive configurations like database credentials, SMTP settings, FFmpeg paths, and timezones from an external `.env` file (a `.env.example` template is provided).
- **Modern PHP Compatibility**: Adapted various parts of the codebase to support **PHP 8.5** (resolving implicit nullable parameter deprecations, obsolete datetime functions, and syntax warnings).
- **Updated Database**: Updated the `schema.sql` file with the correct database structure.

> **Note**: To see the exact files modified and the details of each change, please refer to the **git commits** history in this repository.

---

## Testing Environment

This project has been tested locally under the following conditions:
- **Local Server**: WampServer on Windows
- **PHP**: Version 8.5
- **Database**: MariaDB 11.4.9
- **Access**: Configured using VirtualHosts.

---

## Untested Features & Environments

Please note that the following environments and features have not been tested yet:
- **Email Delivery**: Email sending features (SMTP setup/PHPMailer configuration) are untested.
- **Linux Environments**: All execution and compatibility testing was performed exclusively on Windows using WampServer. Adjustments to file paths, casing, and permissions may be required to run this on Linux-based systems.