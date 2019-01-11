# GUI-and-Database-for-Hospital_SIBD
Project of the course Information Systems and Databases

The goal is to, using PHP and HTML, develop a simple Web-based application to perform the following tasks:

1) A patient calls the healthcare center in order to schedule an appointment. The first task is to check if the patient already exists in the database. 
For this, a set of Web pages are used to search for patients by name. On displayed results, is included the possibility of jumping directly to either Task 2 or Task 3, depending on whether the patient is registered or not.

2) A set of Web pages are used to schedule an appointment of an existing patient with an existing doctor, on a certain date and office.

3) If the patient does not exist in the database, it is necessary to register it first. A set of Web pages allow both operations (the registration of the new patient and the scheduling of the appointment) to be performed in a single transaction. If the scheduling of the appointment fails, then the registration of the patient is cancelled. The scheduling of the appointment will fail if the specified date falls on a weekend.

