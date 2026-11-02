USE jobconnect_db;
INSERT INTO users (name,email,password,role,phone,status)
VALUES ('Demo Recruiter','recruiter@jobconnect.test',
'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.',
'recruiter','9000000001','active')
ON DUPLICATE KEY UPDATE name=VALUES(name);

INSERT INTO companies (user_id,company_name,description,website,location,logo)
SELECT id,'BrightWave Technologies','A growing technology company building useful digital products.',
'https://example.com','Mumbai, India',
'https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=160&h=160&fit=crop'
FROM users WHERE email='recruiter@jobconnect.test'
ON DUPLICATE KEY UPDATE company_name=VALUES(company_name);

INSERT INTO jobs (company_id,category_id,title,description,requirements,location,job_type,salary_min,salary_max,deadline,status)
SELECT c.id,cat.id,d.title,d.description,d.requirements,d.location,d.job_type,d.salary_min,d.salary_max,
DATE_ADD(CURDATE(),INTERVAL 30 DAY),'Approved'
FROM companies c
JOIN (
 SELECT 'Information Technology' category,'PHP Developer' title,
 'Build and maintain dynamic web applications, integrate MySQL databases and collaborate with the product team.' description,
 'PHP, MySQL, HTML, CSS, JavaScript and basic MVC knowledge.' requirements,
 'Mumbai, India' location,'Full-time' job_type,300000 salary_min,600000 salary_max
 UNION ALL SELECT 'Information Technology','Frontend Developer',
 'Create responsive user interfaces and work with designers and backend developers.',
 'HTML, CSS, JavaScript, Bootstrap and responsive design.',
 'Pune, India','Full-time',350000,700000
 UNION ALL SELECT 'Design','UI/UX Designer',
 'Research user needs, create wireframes and prototypes, and improve product usability.',
 'Figma, wireframing, prototyping and a design portfolio.',
 'Remote, India','Full-time',400000,800000
 UNION ALL SELECT 'Marketing','Digital Marketing Intern',
 'Support social media campaigns, content planning, SEO research and reporting.',
 'Good writing skills and interest in digital marketing.',
 'Mumbai, India','Internship',80000,150000
 UNION ALL SELECT 'Information Technology','Python Developer',
 'Develop backend services, write clean code and work with APIs.',
 'Python, SQL, REST APIs, Git and problem-solving skills.',
 'Bengaluru, India','Full-time',450000,900000
 UNION ALL SELECT 'Human Resources','HR Executive',
 'Coordinate recruitment, schedule interviews and support onboarding.',
 'Communication, coordination and documentation skills.',
 'Thane, India','Full-time',250000,450000
) d ON 1=1
JOIN categories cat ON cat.name=d.category
WHERE c.company_name='BrightWave Technologies'
AND NOT EXISTS (SELECT 1 FROM jobs j WHERE j.company_id=c.id AND j.title=d.title);
