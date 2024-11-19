# Exercise: Film Review Management System
Task: Create a PHP-based Film Review Management System for movie enthusiasts. 
The system should allow users to add, update, delete, and view film reviews, with SQLite used to store the review data.

## Review Data:
- Film Title
- Director
- Genre (e.g., Action, Drama, Sci-Fi, Comedy, etc.)
- Rating (1 to 10 scale)
- Review Date
- Review Text
- Reviewer Username

## Requirements:
### 1. Reviews Table
   Display a table with all reviews, showing:
   - Film Title, Director, Genre, Rating, Review Date, and Reviewer Username.
   - Actions for updating and deleting reviews.
   - Add a button above the table to add a new review.

### 2. Add Review Form
   When clicking the add button, redirect to a form with:
   - Text field for the Film Title.
   - Text field for the Director's Name.
   - Dropdown menu for selecting the Genre.
   - Number input field for selecting a Rating (1 to 10).
   - Date field for the Review Date.
   - Text area for the Review Text.

### 3. Delete Review
   When clicking the delete button:
   - Remove the review from the database.
   - If the review has a Rating of 8 or higher, display a confirmation dialog before deletion, asking, "Are you sure you want to delete a highly-rated film review?"

### 4. Update Review
   When clicking the update button:
   - Open a form displaying the current review details.
   - Allow modifications to the film title, director, genre, rating, and review text.
   - Save the updated information back to the database.
   
### Bonus Requirement: Authentication & Authorization:
   Use JWT (JSON Web Token) for user authentication.
   - Only authenticated users can add, update, or delete reviews.
   - Unauthenticated users can only view the reviews without the actions for updating and deleting.
   - Make sure each review shows the reviewer's username, and only the reviewer can delete or update their own reviews.