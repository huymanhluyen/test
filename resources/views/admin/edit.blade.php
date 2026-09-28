<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit User</h1>
        <form action="{{ route('admin.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" maxlength="255" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control"
                    id="email" name="email"
                    value="{{ old('email', $user->email) }}"
                    maxlength="255" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mat khau moi</label>
                <input type="password" class="form-control"
                    id="password" name="password"
                    minlength="8" autocomplete="new-password">
                <div class="form-text"></div>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">
                    Xac nhan mat khau moi
                </label>
                <input type="password" class="form-control"
                    id="password_confirmation" name="password_confirmation"
                    minlength="8" autocomplete="new-password">
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control"
                    id="location" name="location"
                    value="{{ old('location', $user->location) }}"
                    maxlength="255">
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control"
                    id="phone" name="phone"
                    value="{{ old('phone', $user->phone) }}"
                    maxlength="12">
            </div>

            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control"
                    id="age" name="age"
                    value="{{ old('age', $user->age) }}"
                    min="1" max="120">
            </div>
            <button type="submit" class="btn btn-primary">Luu</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    Huy
                </a>
            </form>