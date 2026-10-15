
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <div class="hero">
        <div class="symbol">✦</div>
        <p class="tag">YOUR NEXT EXPERIENCE STARTS HERE</p>
        <h1>Event Registration</h1>
        <p>Join us for something unforgettable.</p>
    </div>

    <form action="register.php" method="POST" id="eventForm">
        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name"
               placeholder="Enter your full name" required maxlength="100">

        <label for="email">Email Address</label>
        <input type="email" id="email" name="email"
               placeholder="you@example.com" required maxlength="150">

        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone"
               placeholder="10-digit mobile number" required
               pattern="[0-9]{10}" maxlength="10">

        <label for="event_name">Choose Your Event</label>
        <select id="event_name" name="event_name" required>
            <option value="">Select an event</option>
            <option value="Tech Fest">Tech Fest</option>
            <option value="Music Night">Music Night</option>
            <option value="Photography Workshop">Photography Workshop</option>
            <option value="Entrepreneurship Seminar">Entrepreneurship Seminar</option>
        </select>

        <button type="submit">Register Now →</button>

        <p class="note">Please check your details before submitting.</p>
    </form>
</div>

<script src="script.js"></script>
</body>
</html>
