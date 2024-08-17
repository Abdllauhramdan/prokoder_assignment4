<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="containermt-5">
    <h2>SubscriptionApplicationForm</h2>

    @if(session('success'))
        <divclass="alertalert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('subscriptions.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <labelfor="name" class="form-label">Name</label>
            <inputtype="text" class="form-control" id="name" name="name" required>
        </div>

        <divclass="mb-3">
            <labelfor="email" class="form-label">Email</label>
            <inputtype="email" class="form-control" id="email" name="email" required>
        </div>

        <divclass="mb-3">
            <labelfor="phone" class="form-label">Phone</label>
            <inputtype="text" class="form-control" id="phone" name="phone" required>
        </div>

        <divclass="mb-3">
            <labelfor="sport_id" class="form-label">SelectSport</label>
            <selectclass="form-control" id="sport_id" name="sport_id" required>
                @foreach($sportsas $sport)
                    <optionvalue="{{ $sport->id }}">{{ $sport->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
