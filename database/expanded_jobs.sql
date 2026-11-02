USE jobconnect_db;

-- Demo-only recruiter accounts. All six use the demo password: password.
-- Change these passwords before deploying the application publicly.
INSERT INTO users (name,email,password,role,phone,status) VALUES
('BrightWave Recruiter','recruiter@jobconnect.test','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.','recruiter','9000000001','active'),
('MarketMint Recruiter','marketmint@jobconnect.test','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.','recruiter','9000000002','active'),
('PixelCraft Recruiter','pixelcraft@jobconnect.test','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.','recruiter','9000000003','active'),
('FinEdge Recruiter','finedge@jobconnect.test','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.','recruiter','9000000004','active'),
('CareFirst Recruiter','carefirst@jobconnect.test','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.','recruiter','9000000005','active'),
('LearnSphere Recruiter','learnsphere@jobconnect.test','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.','recruiter','9000000006','active')
ON DUPLICATE KEY UPDATE name=VALUES(name), role='recruiter', status='active';

INSERT INTO companies (user_id,company_name,description,website,location,logo)
SELECT u.id, x.company_name, x.description, x.website, x.location, x.logo
FROM (
 SELECT 'recruiter@jobconnect.test' email,'BrightWave Technologies' company_name,
 'A product engineering company building reliable web platforms and digital services.' description,
 'https://example.com' website,'Mumbai, India' location,
 'https://ui-avatars.com/api/?name=BrightWave&background=172747&color=ffffff&size=160&bold=true' logo
 UNION ALL SELECT 'marketmint@jobconnect.test','MarketMint Media',
 'A creative growth agency helping ambitious brands connect with customers.',
 'https://example.com','Pune, India',
 'https://ui-avatars.com/api/?name=MarketMint&background=7b61d1&color=ffffff&size=160&bold=true'
 UNION ALL SELECT 'pixelcraft@jobconnect.test','PixelCraft Studio',
 'A digital design studio creating useful, beautiful products and brand experiences.',
 'https://example.com','Bengaluru, India',
 'https://ui-avatars.com/api/?name=PixelCraft&background=e87955&color=ffffff&size=160&bold=true'
 UNION ALL SELECT 'finedge@jobconnect.test','FinEdge Consulting',
 'A finance and advisory firm supporting businesses and individuals with smarter decisions.',
 'https://example.com','Mumbai, India',
 'https://ui-avatars.com/api/?name=FinEdge&background=168a78&color=ffffff&size=160&bold=true'
 UNION ALL SELECT 'carefirst@jobconnect.test','CareFirst Hospitals',
 'A multi-specialty healthcare network focused on safe and compassionate patient care.',
 'https://example.com','Thane, India',
 'https://ui-avatars.com/api/?name=CareFirst&background=dc6681&color=ffffff&size=160&bold=true'
 UNION ALL SELECT 'learnsphere@jobconnect.test','LearnSphere Academy',
 'An education group delivering engaging learning experiences in classrooms and online.',
 'https://example.com','Remote, India',
 'https://ui-avatars.com/api/?name=LearnSphere&background=3976b9&color=ffffff&size=160&bold=true'
) x
JOIN users u ON u.email=x.email
ON DUPLICATE KEY UPDATE
 company_name=VALUES(company_name), description=VALUES(description),
 website=VALUES(website), location=VALUES(location), logo=VALUES(logo);

-- 30 vacancies, five in each of the six categories.
-- The LEFT JOIN makes this script safe to import again without duplicating jobs.
INSERT INTO jobs
(company_id,category_id,title,description,requirements,location,job_type,salary_min,salary_max,deadline,status)
SELECT c.id, cat.id, d.title, d.description, d.requirements, d.location, d.job_type,
       d.salary_min, d.salary_max, DATE_ADD(CURDATE(), INTERVAL 30 DAY), 'Approved'
FROM (
 SELECT 'recruiter@jobconnect.test' email,'Information Technology' category,'PHP Developer' title,
 'Build and maintain secure PHP applications, develop database-backed features and collaborate with the product team.' description,
 'PHP, MySQL, HTML, CSS, JavaScript, Git and basic MVC knowledge.' requirements,
 'Mumbai, India' location,'Full-time' job_type,360000 salary_min,650000 salary_max
 UNION ALL SELECT 'marketmint@jobconnect.test','Marketing','SEO Specialist',
 'Improve organic search performance through keyword research, technical SEO audits and content optimisation.',
 'SEO tools, keyword research, Google Analytics and strong analytical skills.','Pune, India','Full-time',300000,550000
 UNION ALL SELECT 'pixelcraft@jobconnect.test','Design','UI/UX Designer',
 'Create intuitive user journeys, wireframes and polished prototypes for responsive web and mobile products.',
 'Figma, user research, wireframing, prototyping and a portfolio.','Bengaluru, India','Full-time',420000,800000
 UNION ALL SELECT 'finedge@jobconnect.test','Finance','Accountant',
 'Maintain financial records, reconcile accounts, prepare reports and support month-end closing.',
 'B.Com, accounting principles, Excel and familiarity with Tally or similar software.','Mumbai, India','Full-time',280000,480000
 UNION ALL SELECT 'carefirst@jobconnect.test','Healthcare','Medical Assistant',
 'Support clinical teams with patient intake, appointment coordination and basic medical documentation.',
 'Relevant healthcare qualification, communication skills and patient-care awareness.','Thane, India','Full-time',240000,420000
 UNION ALL SELECT 'learnsphere@jobconnect.test','Education','School Teacher',
 'Plan lessons, teach assigned subjects, assess student progress and communicate with parents.',
 'Graduate degree, teaching qualification and classroom communication skills.','Remote, India','Full-time',300000,520000
 UNION ALL SELECT 'recruiter@jobconnect.test','Information Technology','Python Developer',
 'Develop Python services, integrate APIs, write maintainable code and improve application performance.',
 'Python, SQL, REST APIs, Git and problem-solving skills.','Bengaluru, India','Full-time',450000,850000
 UNION ALL SELECT 'marketmint@jobconnect.test','Marketing','Social Media Manager',
 'Plan social calendars, create campaigns, engage online communities and report channel performance.',
 'Social media strategy, copywriting, Canva and analytics.','Mumbai, India','Full-time',320000,600000
 UNION ALL SELECT 'pixelcraft@jobconnect.test','Design','Graphic Designer',
 'Design digital campaign creatives, brand assets, presentations and marketing collateral.',
 'Adobe Illustrator or Photoshop, typography, layout and a design portfolio.','Pune, India','Full-time',280000,520000
 UNION ALL SELECT 'finedge@jobconnect.test','Finance','Financial Analyst',
 'Analyse financial data, prepare forecasts and dashboards, and communicate business insights.',
 'Finance or accounting degree, Excel, financial modelling and analytical skills.','Mumbai, India','Full-time',450000,800000
 UNION ALL SELECT 'carefirst@jobconnect.test','Healthcare','Registered Nurse',
 'Deliver patient care, monitor clinical observations and coordinate with doctors and hospital teams.',
 'Recognised nursing qualification, current registration and patient-care experience.','Thane, India','Full-time',300000,540000
 UNION ALL SELECT 'learnsphere@jobconnect.test','Education','Online Tutor',
 'Deliver engaging online lessons, prepare learning materials and track learner progress.',
 'Subject expertise, clear communication and comfort with online teaching tools.','Remote, India','Part-time',180000,360000
 UNION ALL SELECT 'recruiter@jobconnect.test','Information Technology','Java Developer',
 'Design and implement Java application components, write tests and work with relational databases.',
 'Core Java, OOP, SQL, Spring fundamentals and Git.','Pune, India','Full-time',420000,780000
 UNION ALL SELECT 'marketmint@jobconnect.test','Marketing','Digital Marketing Executive',
 'Execute paid and organic campaigns, monitor performance and help optimise lead generation.',
 'SEO/SEM basics, campaign reporting, content planning and analytics.','Mumbai, India','Full-time',300000,560000
 UNION ALL SELECT 'pixelcraft@jobconnect.test','Design','Web Designer',
 'Create responsive page layouts and visual systems that make websites easy to use.',
 'HTML, CSS, responsive design, Figma and visual design fundamentals.','Remote, India','Full-time',300000,580000
 UNION ALL SELECT 'finedge@jobconnect.test','Finance','Banking Executive',
 'Assist customers with account services, documentation, transactions and product information.',
 'Graduate degree, customer service skills and basic banking knowledge.','Pune, India','Full-time',260000,460000
 UNION ALL SELECT 'carefirst@jobconnect.test','Healthcare','Hospital Administrator',
 'Coordinate front-office operations, patient services, staff schedules and administrative processes.',
 'Healthcare administration or management background and strong coordination skills.','Mumbai, India','Full-time',360000,650000
 UNION ALL SELECT 'learnsphere@jobconnect.test','Education','Academic Coordinator',
 'Coordinate academic schedules, support teachers, monitor curriculum delivery and organise assessments.',
 'Education background, planning, communication and documentation skills.','Pune, India','Full-time',320000,560000
 UNION ALL SELECT 'recruiter@jobconnect.test','Information Technology','Frontend Developer',
 'Build accessible responsive interfaces and connect frontend components to backend services.',
 'HTML, CSS, JavaScript, Bootstrap, responsive design and browser debugging.','Pune, India','Full-time',350000,700000
 UNION ALL SELECT 'marketmint@jobconnect.test','Marketing','Content Writer',
 'Write clear website copy, blogs, email campaigns and social content for varied audiences.',
 'Excellent writing, editing, research and basic SEO skills.','Remote, India','Full-time',240000,450000
 UNION ALL SELECT 'pixelcraft@jobconnect.test','Design','Video Editor',
 'Edit short-form and long-form video content, add motion graphics and prepare platform-ready exports.',
 'Premiere Pro or DaVinci Resolve, storytelling and motion graphics basics.','Mumbai, India','Full-time',300000,560000
 UNION ALL SELECT 'finedge@jobconnect.test','Finance','Tax Associate',
 'Assist with tax documentation, return preparation, reconciliations and compliance research.',
 'Commerce or finance degree, tax fundamentals and attention to detail.','Thane, India','Full-time',280000,500000
 UNION ALL SELECT 'carefirst@jobconnect.test','Healthcare','Lab Technician',
 'Collect and process samples, operate laboratory equipment and maintain accurate test records.',
 'Relevant laboratory qualification, safety procedures and careful documentation.','Pune, India','Full-time',240000,430000
 UNION ALL SELECT 'learnsphere@jobconnect.test','Education','Instructional Designer',
 'Develop structured digital learning content, storyboards and assessments for online courses.',
 'Instructional design, content development and familiarity with LMS platforms.','Remote, India','Full-time',400000,700000
 UNION ALL SELECT 'recruiter@jobconnect.test','Information Technology','Data Analyst',
 'Clean datasets, create dashboards and translate business questions into useful data insights.',
 'SQL, Excel, Python or Power BI and data visualisation skills.','Mumbai, India','Full-time',400000,750000
 UNION ALL SELECT 'marketmint@jobconnect.test','Marketing','Marketing Intern',
 'Assist with campaign research, social content, competitor reviews and weekly marketing reports.',
 'Currently studying marketing or business; curiosity, writing and spreadsheet skills.','Mumbai, India','Internship',90000,160000
 UNION ALL SELECT 'pixelcraft@jobconnect.test','Design','Product Designer',
 'Work across discovery, interaction design and prototyping to improve end-to-end product experiences.',
 'Figma, product thinking, user research and a strong case-study portfolio.','Bengaluru, India','Full-time',500000,950000
 UNION ALL SELECT 'finedge@jobconnect.test','Finance','Accounts Intern',
 'Support invoice processing, data entry, reconciliations and preparation of basic finance reports.',
 'Commerce student or graduate, Excel basics and willingness to learn.','Mumbai, India','Internship',100000,180000
 UNION ALL SELECT 'carefirst@jobconnect.test','Healthcare','Healthcare Coordinator',
 'Coordinate patient appointments, records, follow-ups and communication between care teams.',
 'Healthcare administration, organisation and strong interpersonal skills.','Thane, India','Full-time',260000,460000
 UNION ALL SELECT 'learnsphere@jobconnect.test','Education','Corporate Trainer',
 'Deliver engaging professional development sessions and create practical training materials.',
 'Training or teaching experience, presentation skills and subject expertise.','Bengaluru, India','Contract',350000,650000
) d
JOIN users u ON u.email=d.email
JOIN companies c ON c.user_id=u.id
JOIN categories cat ON cat.name=d.category
LEFT JOIN jobs existing ON existing.company_id=c.id AND existing.title=d.title
WHERE existing.id IS NULL;
