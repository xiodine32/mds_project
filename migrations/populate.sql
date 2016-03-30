INSERT INTO Departments (Title, MaxSize, DeptDescription, StartDate, MonthlyExpenses) VALUES
  ('Mobile', 15, 'Solutions and Applications for mobile devices', '10/05/05', 100000),
  ('QA', 45, 'Quality assurance department', '10/05/98', 60000),
  ('ASP.NET', 25, 'Tasked with developing Web solutions in ASP.NET.', '10/05/02', 60000);

/*management*/
INSERT INTO Employees (RoleID, Account, Password, ManagerID, DepartmentID, FirstName, MiddleInitial, LastName, Title, CNP, Salary, PriorSalary, HireDate, TerminationDate, Administrator)
VALUES
  (NULL, 'ipo', 'parola', NULL, 1, 'Ion', 'M', 'Popescu', 'Ion Popescu', '1060680234565', 2000, 1500, '10/05/13', NULL,
   1);

INSERT INTO Employees (RoleID, Account, Password, ManagerID, DepartmentID, FirstName, MiddleInitial, LastName, Title, CNP, Salary, PriorSalary, HireDate, TerminationDate, Administrator)
VALUES
  (NULL, 'mio', 'parola', 1, 1, 'Maria', 'I', 'Ionescu', 'Maria Ionescu', '2060670296665', 1200, 800, '10/10/14', NULL,
   0);