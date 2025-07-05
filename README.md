# LAMPConnect

![Built with PHP](https://img.shields.io/badge/Built%20with-PHP-8892BF?style=flat-square&logo=php)
![License: MIT](https://img.shields.io/badge/License-MIT-green?style=flat-square)
![Status: Stable](https://img.shields.io/badge/Status-v1.0.0-blue?style=flat-square)

LAMPConnect is a secure, modular, and user-focused web application built on the **LAMP stack** (Linux, Apache, MySQL, PHP).  
It enables both guest and registered users to submit messages, while administrators have role-based tools to manage users and moderate content.

Styled with a retro green terminal theme inspired by _Mr. Robot_, the app includes dynamic modals, user authentication, and admin moderation tools.

---

<details>
<summary><strong>📚 Table of Contents</strong></summary>

- [Project Structure](#project-structure)
- [Features](#features)
  - [Users](#users)
  - [Admins & Super Admins](#admins--super-admins)
- [Setup & Installation](#setup--installation)
- [Design & UX](#design--ux)
- [Security Features](#security-features)
- [Testing Guide](#testing-guide)
- [Screenshots](#screenshots)
- [Contributing](#contributing)
- [License](#license)
- [Credits](#credits)
- [Deployment Tips](#deployment-tips)

</details>

---

## Project Structure

LAMPConnect/
├── actions/              # Form handlers (login, register, update profile, etc.)
├── css/                  # Modular CSS files (layout, themes, animations)
├── fonts/                # Terminal-style fonts (VCR, MrRobot)
├── images/               # Static images and icons
├── includes/             # Shared PHP logic (auth, config, db, header, footer)
├── js/                   # Modular JavaScript (modals, navbar, etc.)
├── index.php             # Homepage
├── contact.php           # Contact form for guests and users
├── dashboard.php         # User dashboard with message history
├── admin-panel.php       # Admin dashboard with controls
├── super_manage_users.php# Super admin-only user management panel
└── ... other views

## Features

### Users

- Registration and login with validation
- Edit profile and change password
- Submit messages with preview modal
- View message history with modal detail
- Favorite/unfavorite messages

### Admins & Super Admins

- Role-based access control
- Message moderation (with confirmation modals)
- User management (promote, demote, delete)
- Secure forms and permission checks

## Setup & Installation

### 1. Prerequisites

```bash
sudo apt update
sudo apt install apache2 mysql-server php libapache2-mod-php php-mysql
```

### 2. Clone the repository

```bash
git clone https://github.com/yourusername/lampconnect.git
cd lampconnect
```

### 3. MySQL Setup

- Create a database (e.g. `myphp_site`)
- Import the schema if provided

### 4. Configure `config.php`

```php
// config.php
$dbHost = 'localhost';
$dbName = 'myphp_site';
$dbUser = 'your_db_user';
$dbPass = 'your_password';
```

> ⚠️ Do not commit `config.php` — it's listed in `.gitignore`.

### 5. Optional Email Setup

- Configure `msmtp` or your mail transport
- Adjust `mail.php` with SMTP settings or use a Gmail App Password

### 6. Permissions

```bash
sudo chown -R www-data:www-data /var/www/html/lampconnect
sudo chmod -R 755 /var/www/html/lampconnect
```

## Design & UX

- Terminal-style UI with green neon effects
- Typewriter and scroll animations
- Responsive layout
- Fonts: VCR OSD Mono, MrRobot

## Security Features

- All user input is escaped via `htmlspecialchars()`
- Prepared SQL statements prevent injection
- Passwords stored with `password_hash()` and verified with `password_verify()`
- Role-based file-level access (`require_auth.php`, `require_admin.php`, etc.)
- Email input validation and error feedback
- Confirmation modals for critical actions
- HTTPS strongly recommended in production

## Testing Guide

- Test all features:
  - Guest and user message submission
  - Admin message moderation
  - Super admin user management
  - Unauthorized access is correctly blocked

- Verify:
  - Password change
  - Modal previews
  - Email fallback behavior

## Screenshots

> Screenshots will be added in a future update.

## Contributing

Feel free to fork and contribute!  
I'm open to suggestions, pull requests, and improvements on the UX, security, or features.

## License

This project is licensed under the [MIT License](LICENSE).

## Credits

- Fonts:
  [VCR OSD Mono](https://www.dafont.com/vcr-osd-mono.font)  
  [MrRobot](https://fontmeme.com/fonts/mrrobot-font/)

- Inspired by the _Mr. Robot_ terminal aesthetic
- Built on Linux Mint using VSCodium
- Fueled by coffee and curiosity ☕

## Deployment Tips

- Always use **HTTPS**
- Keep `config.php` secure
- Escape and validate all inputs
- Never store plaintext passwords
- Restrict admin tools via roles

> _Author note: I built this project as a full LAMP stack learning experience. It helped me solidify PHP security practices, modular design, and role-based systems. Feedback is always welcome!_
