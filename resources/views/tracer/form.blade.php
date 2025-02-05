<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graduate Tracer Study Form</title>
</head>
<body>

    <h2>Graduate Tracer Study Form</h2>

    <form action="{{ url('/tracer-study') }}" method="POST">
        @csrf
        <label for="fullname">Full Name:</label>
        <input type="text" name="fullname" required>

        <label for="age">Age:</label>
        <input type="number" name="age" required>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <label for="employment_status">Employment Status:</label>
        <select name="employment_status" required>
            <option value="Employed">Employed</option>
            <option value="Self-employed">Self-employed</option>
            <option value="Unemployed">Unemployed</option>
        </select>

        <button type="submit">Submit</button>
    </form>

</body>
</html>
