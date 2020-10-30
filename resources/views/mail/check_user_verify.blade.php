<html>
<head>
    <title>Check user verify - Public Insight</title>
</head>
<body>
    <p>
        The Public insight have a new company is created. 
    </p>
    <h3> User information </h3>
    <div>
        <label>User name: </label>
        <span>{{ $user_name }} </span>
    </div>   
        <label>User email: </label>
        <span>{{ $email }} </span>
    </div>
    
    <h3> Company information </h3>
    <div>
        <label>Company number: </label>
        <span>{{ $company_number }} </span>
    </div>   
        <label>Company name: </label>
        <span>{{ $company_name }} </span>
    </div>
    <p>Please <a href="{{ route('login') }}">login</a> Public insight to verify company admin.</p>
</body>
</html>