# Employee Management CRUD API

## ✅ Laravel Assessment Submission

**Candidate:** Shaon Majumder  
**Email:** smazoomder@gmail.com  
**Assessment Duration:** 4 Hours  
**Total Marks:** 100

## Answered Assesment

-   answered all with precision except I could not finish, partially completing IV. Admin Dashboard (Using Vue.js) 1x30 = 30 Marks

## ✔️ Completed Sections

### I. Database Schema – 10 Marks

-   Designed with Laravel migrations.
-   Tables:
    -   `employees` (`uuid`, name, email, department_id, timestamps, soft deletes)
    -   `employee_details` (employee_id, designation, salary, address, joined_date, timestamps)
    -   `departments` (name, description, timestamps, soft deletes)

### II. Bulk Data Insertion – 10 Marks

-   Inserted:
    -   10 departments
    -   100,000 fake employees with corresponding details using factories and seeders [With Chunking to handle large data]

### III. Employee Management APIs – 30 Marks

-   Full REST API:
    -   Create, Read, Update, Delete employee
-   Features:
    -   Laravel Resource Controllers
    -   Route model binding
    -   Form Request Validation
    -   API response formatting
    -   **Security:** Uses `X-API-KEY` header (from `.env`)
    -   **Throttling:** Rate limit by IP (60 req/min)
    -   **Swagger-ready** structure (PHPDoc annotations included)

### V. Application Performance Optimization – Partial

-   ✅ Eager Loading to prevent N+1
-   ✅ Query Optimization
-   ✅ DB Indexing on relevant foreign keys
-   ✅ Caching with Redis (Fallback if not running)
-   ❌ Horizontal scaling & queue optimization (time constraint)

---

## ❌ Not Completed

### IV. Admin Dashboard (Vue.js) – 30 Marks

-   Not implemented due to time constraints

## 🛠️ Setup Instructions

-   **Docker Build**

```bash
docker-compose up --build
```

-   **Security** - Use api key from .env : X_API_KEY=your_api_key and in all api request use header X-API-KEY
-   **Demo** - api demo video - api-demo-2025-05-05 22-00-56.mp4
-   **Launches at** - http://localhost:8000/
-   **Frontend** --

```bash
docker exec -it selise-laravel-app bash
npm run dev
```

## 🔐 Security

-   ✅ API Key Auth (via X-API-KEY header)
-   ✅ Input validation via Form Requests
-   ✅ Rate Limiting by IP
-   ✅ CSRF-safe stateless APIs

## 📈 Performance Highlights

-   Database Optimization - Indexing
-   Indexed foreign keys (employee_id, department_id)
-   Query Optimization - Eager loading
-   Redis caching with helper CacheHelper::getCache() and setCache()
-   Throatling by ip per minute
-   Paginated API responses
-   Efficient
-   SECURE

## ✅ Advantages

-   Clean architecture & SOLID principles
-   Performance optimized
-   Secure and scalable
-   Easily testable
-   Swagger-ready structure
-   Future-ready for frontend integrations (Vue.js, etc.)

## Added

-   API Documentation - [/api/documentation](http://localhost:8000/api/documentation#/)

## contact

smazoomder@gmail.com
