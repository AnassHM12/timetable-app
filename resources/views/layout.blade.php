<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Timetable Manager')</title>
<style>
*{box-sizing:border-box}body{font-family:Segoe UI,Arial,sans-serif;margin:0;background:#f4f6fb;color:#1f2937}
nav{background:#1e3a8a;color:#fff;padding:12px 20px;display:flex;gap:16px;align-items:center;flex-wrap:wrap}
nav a{color:#dbeafe;text-decoration:none;font-weight:600}nav a:hover,nav a.active{color:#fff;text-decoration:underline}
nav .brand{font-size:1.2em;color:#fff;margin-right:12px}
.container{max-width:1100px;margin:24px auto;padding:0 16px}
.card{background:#fff;border-radius:10px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,.08);margin-bottom:20px}
.btn{display:inline-block;padding:8px 14px;border-radius:6px;border:0;cursor:pointer;text-decoration:none;font-weight:600}
.btn-primary{background:#2563eb;color:#fff}.btn-danger{background:#dc2626;color:#fff}.btn-secondary{background:#e5e7eb;color:#111}
table{width:100%;border-collapse:collapse;margin-top:12px}th,td{padding:10px;border-bottom:1px solid #e5e7eb;text-align:left;font-size:.95em}
th{background:#eff6ff}
input,select{padding:8px 10px;border:1px solid #cbd5e1;border-radius:6px;width:100%;margin:4px 0 12px}
form.inline{display:inline}.alert{padding:10px 14px;border-radius:6px;margin-bottom:12px}
.alert-success{background:#dcfce7;color:#166534}.alert-error{background:#fee2e2;color:#991b1b}
.grid-days{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:12px}
.day-col{background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:10px}
.lesson{background:#dbeafe;border-left:4px solid #2563eb;padding:8px;margin-bottom:8px;border-radius:4px;font-size:.9em}
.filters{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:12px}.filters select{width:auto;min-width:160px}
.pagination{margin-top:12px}
</style>
</head>
<body>
<nav>
<span class="brand">📅 Timetable Manager</span>
<a href="{{ route('home') }}">Grid</a>
<a href="{{ route('timetable.index') }}">Lessons</a>
<a href="{{ route('classes.index') }}">Classes</a>
<a href="{{ route('subjects.index') }}">Subjects</a>
<a href="{{ route('teachers.index') }}">Teachers</a>
<a href="{{ route('rooms.index') }}">Rooms</a>
</nav>
<div class="container">
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
@if($errors->any())<div class="alert alert-error"><ul style="margin:0;padding-left:18px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
@yield('content')
</div>
</body>
</html>
