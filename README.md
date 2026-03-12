PART 1 – NORMALIZATION CHALLENGE
1. Student_Grades_Raw (Unnormalized)
Columns:
•	StudentID
•	StudentName
•	CourseID
•	CourseName
•	ProfessorName
•	ProfessorEmail
•	Grade
Example data:
StudentID	StudentName	CourseID	CourseName	ProfessorName	ProfessorEmail	Grade
1	Nguyen An	101	Database Systems	Dr. Le	le@uni.edu	A
1	Nguyen An	102	Web Development	Dr. Tran	tran@uni.edu	B+
2	Tran Binh	101	Database Systems	Dr. Le	le@uni.edu	A-

TASK 1 
1. Redundant Columns
Some columns contain repeated data:
•	StudentName repeats whenever a student takes multiple courses.
•	CourseName repeats for each student enrolled in the same course.
•	ProfessorName repeats for each course row.
•	ProfessorEmail repeats multiple times.
This redundancy increases storage and can cause inconsistencies.

2. Update Anomalies
Professor Email Change
If a professor changes their email address, the update must be made in multiple rows. If one row is not updated, the data becomes inconsistent.
Course Rename
If the course name changes (for example "Database Systems" to another name), every row containing that course must be updated.
Student Name Change
If a student updates their name, the change must be applied to multiple rows.
3. Transitive Dependencies
The table contains transitive dependencies:
•	StudentID → StudentName
•	CourseID → CourseName
•	ProfessorName → ProfessorEmail
These dependencies violate Third Normal Form (3NF) because non-key attributes depend on other non-key attributes.

TASK 2 
To eliminate redundancy and anomalies, the table is decomposed into four tables:
•	Students
•	Courses
•	Professors
•	Enrollments

Schema Draft
Table	Primary Key	Foreign Keys	Non-key Columns
Students	StudentID	None	StudentName
Courses	CourseID	ProfessorID	CourseName
Professors	ProfessorID	None	ProfessorName, ProfessorEmail
Enrollments	(StudentID, CourseID)	StudentID, CourseID	Grade

Explanation of Each Table
Students
Stores information about students.
Attributes:
•	StudentID (Primary Key)
•	StudentName
Professors
Stores information about professors.
Attributes:
•	ProfessorID (Primary Key)
•	ProfessorName
•	ProfessorEmail
Courses
Stores course information and links each course to a professor.
Attributes:
•	CourseID (Primary Key)
•	CourseName
•	ProfessorID (Foreign Key referencing Professors)

Enrollments
Represents the relationship between students and courses.
Attributes:
•	StudentID (Foreign Key referencing Students)
•	CourseID (Foreign Key referencing Courses)
•	Grade
Primary Key: (StudentID, CourseID)
The schema is decomposed into four tables (Students, Professors, Courses, and Enrollments) to eliminate redundancy and update anomalies. This design ensures that the database structure satisfies Third Normal Form (3NF).
Part 2:
1.	AUTHOR – BOOK
Relationship Type: 1:N
FK Location: Book
2.	CITIZEN – PASSPORT
Relationship Type: 1:1
FK Location: Passport
3.	CUSTOMER – ORDER
Relationship Type: 1:N
FK Location: Order
4.	STUDENT – CLASS
Relationship Type: M:N
FK Location: Enrollment table
5.	TEAM – PLAYER
Relationship Type: 1:N
FK Location: Player
