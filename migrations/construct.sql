DROP TABLE IF EXISTS Departments;
DROP TABLE IF EXISTS Roles;
DROP TABLE IF EXISTS Employees;
DROP TABLE IF EXISTS Educations;
DROP TABLE IF EXISTS Contacts;
DROP TABLE IF EXISTS Projects;
DROP TABLE IF EXISTS Sprints;
DROP TABLE IF EXISTS Tasks;

CREATE TABLE Departments (
  departmentID    INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  title           VARCHAR(50)     NOT NULL,
  maxSize         INT             NOT NULL,
  deptDescription TEXT            NULL,
  startDate       DATE            NOT NULL,
  monthlyExpenses DOUBLE          NOT NULL
);

# tester/ senior developer / project manager / recruiter
CREATE TABLE Roles (
  roleID         INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name           VARCHAR(50)     NOT NULL,
  jobDescription TEXT,
  averageSalary  DOUBLE          NOT NULL
);

CREATE TABLE Employees (
  employeeID      INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  roleID          INT,
  account         VARCHAR(50) NOT NULL UNIQUE,
  password        VARCHAR(64) NOT NULL,
  managerID       INT,
  departmentID    INT,
  firstName       VARCHAR(50) NOT NULL,
  middleInitial   CHAR(1),
  lastName        VARCHAR(50) NOT NULL,
  title           VARCHAR(50) NOT NULL,
  cnp             VARCHAR(13) NOT NULL,
  salary          DOUBLE      NOT NULL,
  priorSalary     DOUBLE      NOT NULL,
  hireDate        DATE        NOT NULL,
  terminationDate DATE        NULL,
  administrator   INT(1)      NOT NULL,
  CONSTRAINT FK_RoleID FOREIGN KEY (roleID)
  REFERENCES Roles (roleID)
    ON DELETE SET NULL,
  CONSTRAINT FK_DepartmentID FOREIGN KEY (departmentID)
  REFERENCES Departments (departmentID)
    ON DELETE SET NULL,
  CONSTRAINT FK_ManagerID FOREIGN KEY (managerID)
  REFERENCES Employees (employeeID)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);
CREATE TABLE Educations (
  educationID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  title       VARCHAR(50)     NOT NULL,
  startDate   DATE            NOT NULL,
  endDate     DATE            NOT NULL,
  degree      VARCHAR(50)     NOT NULL,
  employeeID  INT             NOT NULL,
  CONSTRAINT FK_EmployeeID FOREIGN KEY (employeeID)
  REFERENCES Employees (employeeID)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
);
CREATE TABLE Contacts (
  contactID       INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  contactName     VARCHAR(50)     NOT NULL,
  phoneNumber     VARCHAR(13),
  faxNumber       VARCHAR(13),
  email           VARCHAR(50),
  physicalAddress VARCHAR(75)
);
CREATE TABLE Projects (
  projectID      INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  title          VARCHAR(50)     NOT NULL,
  startDate      DATE            NOT NULL,
  endDate        DATE            NOT NULL,
  contractNumber VARCHAR(50)     NOT NULL,
  pjDescription  TEXT            NOT NULL,
  budget         DOUBLE          NOT NULL,
  departmentID   INT,
  contactID      INT             NOT NULL,
  CONSTRAINT FK_DepartmentIDProject FOREIGN KEY (departmentID)
  REFERENCES Departments (departmentID)
    ON DELETE SET NULL,
  CONSTRAINT FK_ContactID FOREIGN KEY (contactID)
  REFERENCES Contacts (contactID)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
);

CREATE TABLE Sprints (
  sprintID  INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  projectID INT             NOT NULL,
  startDate DATE            NOT NULL,
  endDate   DATE            NOT NULL,
  CONSTRAINT FK_ProjectID FOREIGN KEY (projectID)
  REFERENCES Projects (projectID)
    ON DELETE CASCADE
    ON UPDATE NO ACTION
);

CREATE TABLE Tasks (
  taskID          INT PRIMARY KEY NOT NULL AUTO_INCREMENT,

  sprintID        INT,
  employeeID      INT,
  roleID          INT,

  startDate       DATE,
  endDate         DATE,

  taskDescription TEXT            NOT NULL,
  difficulty      INT(2)          NOT NULL,

  estimation      INT,

  CONSTRAINT FK_SprintID FOREIGN KEY (sprintID)
  REFERENCES Sprints (sprintID)
    ON DELETE SET NULL
    ON UPDATE NO ACTION,

  CONSTRAINT FK_EmployeeIDTasks FOREIGN KEY (employeeID)
  REFERENCES Employees (employeeID)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,

  CONSTRAINT FK_RoleIDTasks FOREIGN KEY (roleID)
  REFERENCES Roles (roleID)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);