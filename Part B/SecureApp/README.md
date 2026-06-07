# Secure App (Part B)

A small, secure PHP application built from scratch. It rebuilds the three
features that were vulnerable in DVWA (Part A), this time with security built
in from the start.

## Run it

With Docker (same workflow as Part A):

    docker compose up --build

Then open http://localhost:8080

Demo login: `admin` / `Passw0rd!`

(Without Docker, if you have PHP 8 with pdo_sqlite installed:
`php -S localhost:8080 -t public`)

## Features and the control that secures each one

| Feature | DVWA flaw it replaces | Security control |
|---|---|---|
| User lookup | SQL Injection | Input validation (digits only) + PDO prepared statement |
| Greeting | Reflected XSS | Output encoding with htmlspecialchars |
| File viewer | File Inclusion / path traversal | Strict file name whitelist |

## Cross cutting controls

- Login required for every feature page
- Passwords stored as bcrypt hashes (password_hash / password_verify)
- Session id regenerated on login (stops session fixation)
- Session cookie set HttpOnly and SameSite=Lax
- Per session CSRF token checked on the login form
- Security headers: Content-Security-Policy, X-Frame-Options, X-Content-Type-Options, Referrer-Policy
- Generic login error message, database errors are not shown to the user

## Layout

    public/   the pages served to the browser
    src/      database connection and auth/csrf helpers
    data/     the sqlite database, created on first run (not committed)
