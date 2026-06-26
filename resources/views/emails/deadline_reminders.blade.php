<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rappel de vos tâches</title>
    <style>
        body {
            font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f1f5f9;
            color: #334155;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            padding: 32px 24px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .header p {
            margin: 8px 0 0 0;
            color: #94a3b8;
            font-size: 14px;
        }
        .content {
            padding: 32px 24px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 12px;
        }
        .intro {
            font-size: 15px;
            line-height: 1.6;
            color: #64748b;
            margin-bottom: 24px;
        }
        .stats-grid {
            margin-bottom: 24px;
        }
        .stat-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 12px;
        }
        .stat-label {
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
        }
        .stat-value {
            font-size: 28px;
            font-weight: 800;
            margin-top: 4px;
        }
        .stat-nouveau {
            border-left: 5px solid #475569;
        }
        .stat-nouveau .stat-value {
            color: #475569;
        }
        .stat-planifie {
            border-left: 5px solid #3b82f6;
        }
        .stat-planifie .stat-value {
            color: #3b82f6;
        }
        .stat-en_cours {
            border-left: 5px solid #f97316;
        }
        .stat-en_cours .stat-value {
            color: #f97316;
        }
        .btn-container {
            text-align: center;
            margin-top: 32px;
        }
        .btn {
            display: inline-block;
            background-color: #3b82f6;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 28px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2), 0 2px 4px -1px rgba(59, 130, 246, 0.1);
        }
        .footer {
            background-color: #f8fafc;
            padding: 24px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
        .footer a {
            color: #3b82f6;
            text-decoration: none;
        }
    </style>
</head>
<body>
    @php
        $nouveauCount = $tasks->where('etat', 'nouveau')->count();
        $planifieCount = $tasks->where('etat', 'planifie')->count();
        $enCoursCount = $tasks->where('etat', 'en_cours')->count();
        $totalCount = $tasks->count();
    @endphp
    <div class="container">
        <div class="header">
            <h1>📋 Rappel de vos Tâches</h1>
            <p>Le point sur vos objectifs d'aujourd'hui</p>
        </div>
        <div class="content">
            <div class="greeting">Bonjour {{ $user->prenom }} {{ $user->nom }},</div>
            <div class="intro">
                Voici le récapitulatif du nombre de tâches en cours avec échéance et rappel correspondant à aujourd'hui (Total : <strong>{{ $totalCount }}</strong>) :
            </div>

            <div class="stats-grid">
                <!-- Tâches Nouvelles -->
                <div class="stat-card stat-nouveau">
                    <div class="stat-label">Nouveau</div>
                    <div class="stat-value">{{ $nouveauCount }}</div>
                </div>

                <!-- Tâches Planifiées -->
                <div class="stat-card stat-planifie">
                    <div class="stat-label">Planifié</div>
                    <div class="stat-value">{{ $planifieCount }}</div>
                </div>

                <!-- Tâches En cours -->
                <div class="stat-card stat-en_cours">
                    <div class="stat-label">En cours</div>
                    <div class="stat-value">{{ $enCoursCount }}</div>
                </div>
            </div>

            <div class="btn-container">
                <a href="{{ config('app.url') }}" class="btn">Accéder à mon espace</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} TodoGestion. Tous droits réservés.</p>
            <p>Cet e-mail automatique a été envoyé car des rappels étaient planifiés pour vos tâches.</p>
        </div>
    </div>
</body>
</html>
