ci-exercise
===========

i was instructed to utilize codeigniter (a popular framework) in completing the follow task instructions:

    Create a form to collect information about a campaign. It should include these fields:
    
    -----------------
    Client Name - Dropdown populated from the database (make up 1 or 2 initial values).
    Client Contact - Dropdown populated from the database, based on the Client Name selected. Each contact is
    associated with a Client.
    Campaign Name - Text input.
    Campaign Type - Multi-select with 3 options (Email, Teledemand, SSD).
    Brand - Dropdown populated from the database (Initial options of "Dell" and "HP"). Not tied to the value of
    any other field.
    Start Date - Date field that should allow the user to select a date from a calendar.
    Notes - Textbox input.
    -----------------
     
    3 of the fields (Client Name, Client Contact, & Brand) should have an "Add" button beside them that allows the
    user to add new values via a pop up without leaving or refreshing the form. Adding a new value should verify
    that it's not a duplicate value for that field and store the new value in the database. After successfully
    adding the new value, set it as the value of that field on the form.
     
    Since Client Contact is associated to Client Name, changing the Name should refresh the list of available
    Contacts and clear out the previous selection. Brand is not associated with any other fields so it should
    not be refreshed when other fields are changed.
     
    When the form is submitted you should validate that all fields have been entered except for Notes which
    is optional. At least 1 Campaign Type must be selected. The Contract Date must be in the future. The
    Campaign Name field can only contain letters, numbers and these symbols:   - _ : ! #
     
    If form validation fails, repopulate the previously entered/selected values and display the error messages
    at the top of the form. If form validation passes, save the data to the database. How you structure the
    tables/data is up to you so long as it's easy to pull out later for display.
     
    Finally, create a 2nd page that displays 1 line for each Campaign in the database. It should show the
    following information about each Campaign:
     
    Campaign Name, Client Name, Client Contact, Total # of Types for this Campaign, Brand, Days until
    Start Date (display 0 for dates in the past)

