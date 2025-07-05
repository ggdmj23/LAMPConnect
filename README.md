# 🖥️ LAMPConnect

![Built with PHP](https://img.shields.io/badge/Built%20with-PHP-8892BF?style=for-the-badge&logo=php)
![License: MIT](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)
![Status: WIP](https://img.shields.io/badge/Status-In%20Development-yellow?style=for-the-badge)

**LAMPConnect** is a secure, modular, and user-focused web application built on the **LAMP stack** (Linux, Apache, MySQL, PHP). It enables both guest and registered users to submit messages, while administrators have role-based tools to manage users and moderate content.

Styled with a **retro green terminal theme** inspired by Mr. Robot, LAMPConnect delivers a nostalgic yet modern user experience with dynamic modals and interactive console-like feedback.

---

## 📁 Project Structure

```
LAMPConnect/
├── actions/              # Form handlers (login, register, update profile, etc.)
├── css/                  # Modular CSS files (layout, themes, animations)
├── fonts/                # Terminal-style custom fonts (e.g., VCR, MrRobot)
├── images/               # Static images and icons
├── includes/             # Shared logic and partials (auth, database, header/footer)
├── js/                   # Modular JavaScript files
├── index.php             # Homepage
├── contact.php           # Contact form for guests and users
├── dashboard.php         # User dashboard with message history
├── admin-panel.php       # Admin dashboard with role-based controls
└── ...other PHP views
```

---

## 🚀 Features

### 👤 Users
- 🔐 Secure registration and login
- ⚙️ Profile and password management
- 📨 Submit messages with live preview
- 📜 Message history with modal detail views
- ⭐ Favorite or unfavorite messages

### 👨‍💼 Admins & Super Admins
- 🛂 Role-based access control
- 🧾 Message moderation tools
- 👥 User and role management
- 🧹 Secure deletions and logging

---

## ⚙️ Installation & Setup

### 1. Prerequisites (LAMP Stack)
Install Apache, MySQL, and PHP:

```bash
sudo apt update
sudo apt install apache2 mysql-server php libapache2-mod-php php-mysql
```

### 2. Clone the Repository
```bash
git clone https://github.com/yourusername/lampconnect.git
cd lampconnect
```

### 3. Configure MySQL
- Create a new database (e.g., `myphp_site`)
- Import the schema (`.sql`) if provided

### 4. Configure `config.php`
```php
$dbHost = 'localhost';
$dbName = 'myphp_site';
$dbUser = 'your_user';
$dbPass = 'your_password';
```

### 5. Configure Email (Optional)
- Use `msmtp` with Gmail or any SMTP server
- Adjust `mail.php` to fit your credentials

### 6. Set Permissions
```bash
sudo chown -R www-data:www-data /var/www/html/lampconnect
sudo chmod -R 755 /var/www/html/lampconnect
```

---

## 🎨 Design & UX

- 💻 Terminal-style UI with glowing neon effects
- 🧠 Typewriter and scroll animations
- 🌌 Fully responsive, mobile-friendly
- 🟢 VCR and MrRobot fonts for immersive retro vibes

---

## 🛡️ Security Features

- Escaped all output with `htmlspecialchars()` to prevent XSS
- SQL injection prevention via prepared statements
- Role-based access (`require_auth.php`, `require_admin.php`)
- Password hashing using `password_hash()` and `password_verify()`
- Email validation and error handling
- Optional HTTPS deployment reminder

---

## 🖼️ Screenshots

> Coming soon — UI showcase!

<!--
![Dashboard Preview](screenshots/dashboard.png)
![Modal Preview](screenshots/modal.png)
-->

---

## 🙌 Contributing

Contributions are welcome!  
Feel free to open issues, suggest features, or submit pull requests.

Looking for help with:
- Feature development
- Bug fixes and testing
- Styling and UX polishing
- Documentation and localization

---

## 📄 License

MIT License  
Feel free to use, modify, and share responsibly.

---

## 🧠 Credits & Acknowledgments

- Fonts: [VCR OSD Mono](https://www.dafont.com/vcr-osd-mono.font), [MrRobot](https://fontmeme.com/fonts/mrrobot-font/)
- Inspired by Mr. Robot's iconic console aesthetic
- Built on [Linux Mint](https://linuxmint.com), [VSCodium](https://vscodium.com), and powered by ☕ & ❤️

---

## ✅ Final Tip

🔐 When deploying LAMPConnect online, always enable **HTTPS** and keep your `config.php`, `.env` (if used), and session secrets secure.
