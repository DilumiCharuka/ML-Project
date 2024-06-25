<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control Bulbs</title>
</head>
<body>
    <h1>Control Bulbs</h1>
    <form id="bulbForm">
        <label for="bulb1">Bulb 1:</label>
        <select name="bulb1" id="bulb1">
            <option value="0">Off</option>
            <option value="1">On</option>
        </select>
        <br>
        <label for="bulb2">Bulb 2:</label>
        <select name="bulb2" id="bulb2">
            <option value="0">Off</option>
            <option value="1">On</option>
        </select>
        <br>
        <button type="submit">Submit</button>
    </form>

    <script>
        document.getElementById("bulbForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent default form submission

            var formData = new FormData(this); // Get form data
            var xhr = new XMLHttpRequest(); // Create new XMLHttpRequest object

            // Define what happens on successful data submission
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Parse JSON response
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert(response.message); // Show success message
                    } else {
                        alert(response.message); // Show error message
                    }
                }
            };

            // Define what happens in case of an error
            xhr.onerror = function() {
                alert("Error sending request.");
            };

            // Open a POST request, specifying the endpoint URL
            xhr.open("POST", "cw.php", true);

            // Set the appropriate header for form data
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Send the form data
            xhr.send(new URLSearchParams(formData).toString());
        });
    </script>
</body>
</html>