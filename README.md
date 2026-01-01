# CyfrinDev API

🚧 **UNDER CONSTRUCTION** 🚧  
This project is actively being developed. Features, endpoints, and structure may change without notice.

---

## 📖 Overview

**CyfrinDev API** is a RESTful API built with **Laravel** that serves as the backend for an online learning platform focused on web development courses and tutorials.

The API is designed to manage users, courses, lessons, and related learning resources, and to be consumed by a frontend web or mobile application.

---

## 🚀 Features (Current & Planned)

- User registration and authentication (API-based)
- Course and tutorial management
- Lesson and content organization
- JSON responses for frontend consumption
- Scalable and maintainable architecture using Laravel best practices

> ⚠️ Some features are still in progress and not yet finalized.

---

## 🛠️ Tech Stack

| Technology | Version |
|----------|--------|
| Laravel  | 12.x   |
| PHP      | 8.x    |
| Database | Postgresql |

---

## 📦 Getting Started

### 📋 Prerequisites

- PHP >= 8.0
- Composer
- MySQL or SQLite

---

### 🔧 Installation

1. Clone the repository
```bash
git clone https://github.com/chibelsonda/cyfrindev-api.git
cd cyfrindev-api
```

2. Install dependencies
```bash
composer install
```

3. Create environment file
```bash
cp .env.example .env
```

4. Generate application key
```bash
php artisan key:generate
```

5. Configure database in `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

6. Run migrations
```bash
php artisan migrate
```

---

## ▶️ Running the API

```bash
php artisan serve
```

API will be available at:
```
http://localhost:8000
```

---

## 📡 Sample Endpoints (Subject to Change)

```http
POST   /api/login
GET    /api/courses
GET    /api/courses/{id}
POST   /api/courses
```

---

## 🧪 Project Status

- Authentication: 🔧 In progress
- Course management: 🔧 In progress
- Lessons & tutorials: ⏳ Planned
- API documentation: ⏳ Planned

---

## 👥 Contributing

Contributions, suggestions, and feedback are welcome.

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Open a pull request

---

## 📝 License

MIT License

---

## 📌 Author

Developed by **Chicote Belsonda**  
GitHub: https://github.com/chibelsonda

---

🚀 More features and documentation coming soon.
