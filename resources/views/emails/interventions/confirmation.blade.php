<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmation de votre intervention</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; mx-auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #0d9488;">Confirmation d'Intervention</h2>
        
        <p>Bonjour,</p>
        
        <p>Nous vous informons que l'intervention <strong>{{ $intervention->code }}</strong> a été confirmée.</p>
        
        <div style="background-color: #f9fafb; padding: 15px; border-radius: 5px; border-left: 4px solid #0d9488; margin: 20px 0;">
            <p style="margin-top: 0;"><strong>Message de l'administrateur :</strong></p>
            <p style="margin-bottom: 0;">{{ $messageContent }}</p>
        </div>
        
        <p>Détails de l'intervention :</p>
        <ul>
            <li><strong>Référence :</strong> {{ $intervention->reference }}</li>
            <li><strong>Code :</strong> {{ $intervention->code }}</li>
            <li><strong>Libellé :</strong> {{ $intervention->libelle }}</li>
            <li><strong>Date de début :</strong> {{ \Carbon\Carbon::parse($intervention->date_debut)->format('d/m/Y') }}</li>
            <li><strong>Date de fin :</strong> {{ \Carbon\Carbon::parse($intervention->date_fin)->format('d/m/Y') }}</li>
        </ul>
        
        <p>Cordialement,<br>
        L'équipe du prestataire AF</p>
    </div>
</body>
</html>
