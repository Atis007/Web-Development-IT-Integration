MVC (Model–View–Controller) is a software design pattern that separates an application into three main parts.

The Model is responsible for data and business logic. It retrieves, stores, and processes data, usually from a database.
The Model does not know anything about the user interface or how the data is displayed.

The View is responsible for presentation. It displays data to the user, typically as HTML. A View should contain only
minimal logic, such as loops and simple conditions, and must not access the database or handle application logic.

The Controller acts as an intermediary between the Model and the View. It receives user input (such as URL parameters or
form data), decides what action should be performed, calls the appropriate Model to obtain data, and selects the View
that will present the result.

In an MVC application, the typical request flow is:
User request → Controller → Model → Controller → View

The main goal of MVC is to improve code organization, readability, and maintainability by clearly separating
responsibilities.

ADDITIONAL INFO:

https://programatori.stud.vts.su.ac.rs/public/docs/starter-topic.html