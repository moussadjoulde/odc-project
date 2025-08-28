@extends('layouts.auth')

@section('content')
    <div class="error-container">
        <div class="error-card">
            <img src="{{ asset('images/errors/404.png') }}" alt="Page non trouvée" class="error-image">
            <h1 class="error-title">404 - Page non trouvée</h1>
            <p class="error-message">Désolé, la page que vous recherchez n'existe pas ou a été déplacée.</p>
            <a href="{{ url('/') }}" class="error-button">
                <i class="bi bi-house-door"></i> Retour à l'accueil
            </a>
        </div>
    </div>
    <style>
        .error-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-gradient);
            padding: 20px;
        }
        
        .error-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        
        .error-image {
            max-width: 300px;
            margin: 0 auto 30px;
            display: block;
        }
        
        .error-title {
            font-size: 3rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 15px;
        }
        
        .error-message {
            font-size: 1.2rem;
            color: #7f8c8d;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .error-button {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }
        
        .error-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            color: white;
        }
        
        .error-button i {
            margin-right: 8px;
        }
    </style>
@endsection
