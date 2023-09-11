$(document).ready(function() {

    // ... (Your existing code for fetching and displaying data)

    $('#myTable').on('click', '#edit', function() {
        var editId = $(this).data('id');
        var editAction = "edit";
        mydata = {
            action: editAction,
            editId: editId
        };
        $.ajax({
            url: 'edit.php',
            type: 'POST',
            dataType: 'json',
            data: mydata,
            success: function(data) { // Use 'response' instead of 'data'
                $("#update_id").val(data.id);
                $("#firstname").val(data.name);
                $("#lastname").val(data.lastname);
                $("#email").val(data.email);
                $("#phone").val(data.phone);
                $("#gender").val(data.gender);
                $("#hobbies").val(data.hobbies);

            },
        });
    });


    // Function to handle data deletion
    $('#myTable').on('click', '#delete', function() {

        var delId = $(this).data('id');
        console.log(delId);
        if (confirm("Are you sure delete the Data"))
            $.ajax({
                url: 'delete.php', // Replace with your API endpoint URL
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'delete',
                    id: delId
                },
                success: function(response) {
                    console.log(response);

                    if (response.success) {
                        // Data deleted successfully, refresh the table
                        fetchData();
                        alert(response.message);
                    } else {
                        console.error(response.message);
                    }
                },
            });

    });

    // Function to fetch and display data
    function fetchData() {
        // var action = "save";
        var action = '';
        var updateId = $('#update_id').val();
        if (updateId) {
            action = 'edit';
        } else {
            action = 'save';
        }

        $.ajax({
            url: 'index.php', // Replace with your API endpoint URL
            method: 'GET',
            dataType: 'json',
            data: {
                action: action
            },
            success: function(data) {
                var tableData = '';
                $.each(data, function(index, item) {
                    tableData += '<tr>';
                    tableData += '<td>' + item.id + '</td>';
                    tableData += '<td>' + item.name + '</td>';
                    tableData += '<td>' + item.lastname + '</td>';
                    tableData += '<td>' + item.email + '</td>';
                    tableData += '<td>' + item.phone + '</td>';
                    tableData += '<td>' + item.gender + '</td>';
                    tableData += '<td>' + item.hobbies + '</td>';
                    // Add button links as needed
                    tableData += '<td><a class="red" id="delete" data-id ="' + item.id + '">Delete</a></td> |<td> <a class="blue" id="edit" data-id="' + item.id + '">Edit</a></td>';
                    tableData += '</tr>';
                });

                // Update the table body with the fetched data
                $('#myTable').html(tableData);
            },
            error: function() {
                $('#myTable').html('<tr><td colspan="8">Error fetching data</td></tr>');
            }
        });
    }

    // Trigger fetchData function when the page loads
    fetchData();



    $('#insert-form').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Serialize the form data
        const formData = $('#insert-form').serialize();

        // Send an Ajax POST request to the server
        $.ajax({
            url: 'index.php', // Backend PHP script for inserting data
            method: 'POST',
            data: formData,
            success: function(response) {
                // Handle the response (e.g., display success message)
                console.log(response);

                // Clear the form if the insertion was successful
                if (response === 'Form submitted successfully') {
                    $('#insert-form')[0].reset();
                    fetchData();
                }

                $('#insert-form')[0].reset();
                fetchData();


            },
            error: function(xhr, status, error) {
                // Handle AJAX errors (e.g., display error messages)
                console.error(xhr.responseText);
            }
        });
    });
});