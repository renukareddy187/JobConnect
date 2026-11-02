# JobConnect – PHP/MySQL Job Portal

A modular MVC-style job portal starter application with:
- Candidate, recruiter and administrator roles
- Registration, login, logout and role checks
- Recruiter company profiles and job posting
- Admin job approval
- Job search and filtering
- Candidate applications and recruiter status updates
- Saved jobs
- Private resume upload/download
- CSRF protection, PDO prepared statements and password hashing

## Requirements
- PHP 8.1+ with PDO MySQL, fileinfo and session extensions
- MySQL 5.7+ / MariaDB 10.4+
- Apache (XAMPP is suitable)
- Composer is optional for this starter

## XAMPP setup
1. Extract `JobConnect` into `C:\xampp\htdocs\`.
2. Start Apache and MySQL in XAMPP.
3. Open phpMyAdmin: `http://localhost/phpmyadmin`.
4. Import `database/jobconnect.sql`.
5. Copy `.env.example` to `.env`.
6. Edit `.env` with your database settings. The sample uses port `3307`; change it to `3306` if that is your MySQL port.
7. Open `http://localhost/JobConnect/public/`.

If Apache uses a different port, include it in the URL, e.g. `http://localhost:8080/JobConnect/public/`.

## Create the first administrator
1. Register a normal account through the website.
2. In phpMyAdmin, open `jobconnect_db` > `users`.
3. Find your account and change `role` from `seeker` to `admin`.
4. Log out and log in again. The Admin link/dashboard will be available.

Do not allow public self-registration as an administrator.

## Recruiter workflow
1. Register and choose the Recruiter role.
2. Open the recruiter dashboard and create a company profile.
3. Post a job. New jobs have `Pending` status.
4. Log in as administrator and approve the job.
5. Approved jobs appear in public search.

## Resume upload
Resumes are stored in `storage/uploads/resumes`, outside the public folder. Recruiters can download a resume only for an application to a job belonging to their company. The starter accepts PDF files up to 5 MB.

## Important production checklist
This is a learning project starter, not a production-audited recruitment service. Before public deployment:
- Use HTTPS and secure cookie settings.
- Set strong, unique database credentials in `.env`.
- Set `APP_DEBUG=false`.
- Keep `.env`, `storage`, and `config` outside the public web root (or deny web access).
- Add email verification and a real password-reset mail flow.
- Add rate limiting, audit logs, malware scanning for uploads, backups and monitoring.
- Review privacy/data-retention requirements.
- Use a production host that supports PHP and MySQL. Configure the document root to `public/`.
- Never commit `.env`, uploaded resumes, logs or production secrets.

## Git workflow
```bash
git init
git add .
git commit -m "Initial JobConnect project structure"
git branch -M main
git remote add origin YOUR_GITHUB_REPOSITORY_URL
git push -u origin main
```
Commit each tested module separately. Example:
```bash
git add app/Controllers/AuthController.php app/Models/User.php
git commit -m "Implement registration and login"
git push
```

## Main routes
- `/` – homepage
- `/?url=auth/register` – registration
- `/?url=auth/login` – login
- `/?url=jobs/index` – browse jobs
- `/?url=jobs/show&id=1` – job details
- `/?url=seeker/dashboard` – candidate dashboard
- `/?url=recruiter/dashboard` – recruiter dashboard
- `/?url=admin/dashboard` – admin dashboard

The app uses query-string routing so it works in a basic XAMPP subfolder without requiring Apache rewrite rules.

## Sample jobs and pictures
After importing `database/jobconnect.sql`, import `database/demo_data.sql` in phpMyAdmin.
It adds six approved sample vacancies: PHP Developer, Frontend Developer, UI/UX Designer,
Digital Marketing Intern, Python Developer and HR Executive.
Demo recruiter login: `recruiter@jobconnect.test` / `password`.
Change this demo password before public deployment. Demo logo and homepage photo use remote
Unsplash images, so an internet connection is required to display them.

## Premium UI refresh
This version includes a redesigned responsive homepage, dark gradient hero, searchable hero form,
category tiles, featured job cards, employer call-to-action, upgraded job search cards and job detail
layout. It uses Google Fonts, Bootstrap Icons and remote Unsplash/Pravatar image URLs; internet is
needed for those remote assets.

## Expanded job catalogue (30 sample vacancies)
1. Keep your existing database and tables.
2. Open phpMyAdmin and select `jobconnect_db`.
3. Choose **Import** and import `database/expanded_jobs.sql`.
4. The script creates six demo employer accounts and 30 approved vacancies (five per category).
5. Refresh `http://localhost/JobConnect/public/`.

Demo recruiter accounts use the password `password`:
- recruiter@jobconnect.test
- marketmint@jobconnect.test
- pixelcraft@jobconnect.test
- finedge@jobconnect.test
- carefirst@jobconnect.test
- learnsphere@jobconnect.test

The job category cards now open filtered job results. The jobs page also supports category,
keyword, location and job-type filters. Do not use these public demo credentials on a live site.


## Additional features in this build
- Candidate profile editing with optimized profile photo uploads.
- Recruiter company logo upload with image resizing and JPEG compression.
- Saved jobs: save/unsave a listing and view saved jobs in the seeker dashboard.
- Resume uploads remain PDF-only and are stored outside the public web root.
- Image uploads accept JPG, PNG and WebP, up to 5 MB; PHP GD is required for resizing/compression.

### Enable image optimization in XAMPP
1. Open XAMPP Control Panel and click Config beside Apache, then open `php.ini`.
2. Find `;extension=gd` and remove the leading semicolon (or enable `extension=gd`).
3. Save `php.ini` and restart Apache.
4. Check `http://localhost/JobConnect/public/` again.

### GitHub: commit in stages (do not upload only once at the end)
Run these commands from the project folder in VS Code terminal, replacing the remote URL with your own repository URL:
```bash
git init
git add .
git commit -m "Initial JobConnect project setup"
git branch -M main
git remote add origin https://github.com/YOUR-USERNAME/YOUR-REPOSITORY.git
git push -u origin main
```
For each later feature, run `git add .`, `git commit -m "Describe the feature"`, and `git push`. Keep `.env`, uploaded resumes, and private user uploads out of Git; `.gitignore` should exclude them.

### Deployment checklist
- Use a PHP 8.1+ host with MySQL and PDO MySQL enabled; enable GD.
- Create a production database and import `database/jobconnect.sql`, then import `database/expanded_jobs.sql` if sample vacancies are wanted.
- Set production values in `.env` (`APP_URL`, database host/name/user/password, `APP_DEBUG=false`). Never upload `.env` to GitHub.
- Point the domain's document root to the project's `public` directory. Keep `storage` outside the public document root.
- Enable HTTPS, use strong database credentials, and test registration, login, role permissions, uploads, job applications and recruiter actions after deployment.

**Still requires your own account/action:** GitHub pushes and live hosting cannot be completed from this ZIP alone. You must create/connect your GitHub repository and choose a hosting provider/domain.
