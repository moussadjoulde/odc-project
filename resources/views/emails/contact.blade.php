<h2>Nouveau message de contact</h2>

<p><strong>Nom :</strong> {{ $first_name }} {{ $last_name }}</p>
<p><strong>Email :</strong> {{ $email }}</p>
<p><strong>Téléphone :</strong> {{ $phone ?? 'Non fourni' }}</p>
<p><strong>Sujet :</strong> {{ $subject }}</p>

<hr>
<p><strong>Message :</strong></p>
<p>{{ $contactMessage }}</p> <!-- Utiliser la nouvelle variable -->
