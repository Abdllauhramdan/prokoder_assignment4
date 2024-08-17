<!DOCTYPE html>
<html>
<head>
    <title>Subscribe</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Subscribe to Our Service</h1>

        <form action="{{ route('subscriptions.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="member_id">Member ID</label>
                <input type="text" class="form-control" id="member_id" name="member_id" required>
            </div>
            <div class="form-group">
                <label for="plan">Subscription Plan</label>
                <select class="form-control" id="plan" name="plan">
                    <option value="basic">Basic</option>
                    <option value="premium">Premium</option>
                    <option value="gold">Gold</option>
                </select>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <button type="submit" class="btn btn-primary">Subscribe</button>
        </form>
    </div>
</body>
</html>
