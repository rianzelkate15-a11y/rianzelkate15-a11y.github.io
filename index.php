<?php
$data = [];
$photoPath = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
        $photoPath = $uploadDir . time() . "_" . $_FILES["photo"]["name"];
        move_uploaded_file($_FILES["photo"]["tmp_name"], $photoPath);
    }
    // Clean all inputs
    foreach ($_POST as $key => $val) { $data[$key] = htmlspecialchars(trim($val)); }
    $data['photo'] = $photoPath;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Executive Modular CV</title>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --slate: #2D3436;
            --cognac: #A36B4F;
            --parchment: #F4F1EE;
            --border: #D1CCC0;
            --white: #FFFFFF;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Outfit', sans-serif; 
            background-color: #E5E5E5; 
            color: var(--slate);
            padding: 40px 0;
        }

        .container { max-width: 1000px; margin: 0 auto; }

        /* --- STYLISH FORM --- */
        .form-container {
            background: var(--white);
            padding: 50px;
            border-top: 8px solid var(--cognac);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .form-header { margin-bottom: 30px; }
        .form-header h2 { font-family: 'Libre Baskerville', serif; color: var(--cognac); }
        
        .grid-form { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .span-2 { grid-column: span 2; }
        
        label { display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 5px; text-transform: uppercase; color: var(--cognac); }
        input, textarea {
            width: 100%; padding: 12px; border: 1px solid var(--border);
            border-radius: 4px; font-family: inherit; font-size: 0.95rem;
        }
        
        .btn-submit {
            background: var(--slate); color: white; border: none; padding: 15px 40px;
            font-weight: 700; cursor: pointer; border-radius: 4px; transition: 0.3s;
        }
        .btn-submit:hover { background: var(--cognac); }

        /* --- CV DESIGN --- */
        .cv-page {
            background: var(--white);
            min-height: 1100px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 0 40px rgba(0,0,0,0.15);
        }

        /* Top Header Block */
        .cv-header {
            background: var(--slate);
            color: var(--white);
            padding: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-text h1 { font-family: 'Libre Baskerville', serif; font-size: 3.5rem; letter-spacing: -1px; margin-bottom: 10px; }
        .header-text p { color: var(--cognac); font-weight: 600; text-transform: uppercase; letter-spacing: 3px; }
        
        .header-photo { width: 280px; height: 250px; border: 5px solid var(--cognac); overflow: hidden; }
        .header-photo img { width: 100%; height: 100%; object-fit: cover; }

        /* Contact Strip */
        .contact-strip {
            background: var(--cognac);
            color: white;
            padding: 15px 60px;
            display: flex;
            gap: 30px;
            font-size: 0.9rem;
        }

        /* Main Content Grid */
        .cv-body {
            display: grid;
            grid-template-columns: 2fr 1fr;
            flex-grow: 1;
        }

        .main-col { padding: 50px 40px 50px 60px; border-right: 1px solid var(--parchment); }
        .side-col { padding: 50px 60px 50px 40px; background: var(--parchment); }

        .section-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 1.4rem;
            color: var(--slate);
            border-bottom: 2px solid var(--cognac);
            padding-bottom: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .entry { margin-bottom: 25px; }
        .entry h4 { font-size: 1.1rem; font-weight: 700; }
        .entry .meta { color: var(--cognac); font-weight: 600; font-size: 0.85rem; margin-bottom: 5px; }
        .entry p { font-size: 0.95rem; line-height: 1.6; color: #555; white-space: pre-line; }

        .skill-list { list-style: none; }
        .skill-list li { 
            background: var(--white); 
            margin-bottom: 8px; 
            padding: 8px 12px; 
            font-size: 0.9rem; 
            border-left: 3px solid var(--cognac);
            font-weight: 600;
        }

        @media print { .no-print { display: none; } body { padding: 0; } .cv-page { box-shadow: none; } }
    </style>
</head>
<body>

<div class="container">
    <?php if ($_SERVER["REQUEST_METHOD"] != "POST"): ?>
    <div class="form-container">
        <div class="form-header">
            <h2>Curriculum Vitae</h2>
            <p>Fill in your details to generate a high-impact executive CV.</p>
        </div>
        <form method="POST" enctype="multipart/form-data" class="grid-form">
            <div><label>Full Name</label><input type="text" name="name" required></div>
            <div><label>Target Job Title</label><input type="text" name="title"></div>
            <div><label>Email</label><input type="email" name="email"></div>
            <div><label>Phone</label><input type="text" name="phone"></div>
            <div><label>Location</label><input type="text" name="loc" placeholder="City, Country"></div>
            <div><label>Photo</label><input type="file" name="photo"></div>
            
            <div class="span-2"><label>Professional Summary</label><textarea name="bio" rows="3"></textarea></div>
            <div class="span-2"><label>Work Experience (Title | Company | Dates | Details)</label><textarea name="exp" rows="6"></textarea></div>
            <div class="span-2"><label>Education</label><textarea name="edu" rows="3"></textarea></div>
            <div><label>Skills (Comma Separated)</label><input type="text" name="skills"></div>
            <div><label>Languages</label><input type="text" name="lang"></div>
            <div class="span-2"><label>Certifications & Awards</label><textarea name="certs" rows="2"></textarea></div>
            
            <div class="span-2"><button type="submit" class="btn-submit">Build My CV</button></div>
        </form>
    </div>

    <?php else: ?>
    <div class="cv-page">
        <div class="cv-header">
            <div class="header-text">
                <h1><?= strtoupper($data['name']) ?></h1>
                <p><?= $data['title'] ?></p>
            </div>
            <?php if ($data['photo']): ?>
                <div class="header-photo"><img src="<?= $data['photo'] ?>"></div>
            <?php endif; ?>
        </div>

        <div class="contact-strip">
            <span><i class="fa fa-envelope"></i> <?= $data['email'] ?></span>
            <span><i class="fa fa-phone"></i> <?= $data['phone'] ?></span>
            <span><i class="fa fa-map-marker"></i> <?= $data['loc'] ?></span>
        </div>

        <div class="cv-body">
            <div class="main-col">
                <div class="section">
                    <h3 class="section-title"><i class="fa fa-user"></i> Profile</h3>
                    <p style="line-height: 1.8; color: #444;"><?= $data['bio'] ?></p>
                </div>

                <div class="section" style="margin-top: 40px;">
                    <h3 class="section-title"><i class="fa fa-briefcase"></i> Experience</h3>
                    <div class="entry">
                        <p><?= $data['exp'] ?></p>
                    </div>
                </div>

                <div class="section" style="margin-top: 40px;">
                    <h3 class="section-title"><i class="fa fa-graduation-cap"></i> Education</h3>
                    <div class="entry">
                        <p><?= $data['edu'] ?></p>
                    </div>
                </div>
            </div>

            <div class="side-col">
                <h3 class="section-title">Core Skills</h3>
                <ul class="skill-list">
                    <?php 
                    $skills = explode(',', $data['skills']);
                    foreach($skills as $s) if(trim($s)) echo "<li>".trim($s)."</li>";
                    ?>
                </ul>

                <br><br>
                <h3 class="section-title">Languages</h3>
                <p style="font-weight: 600; color: var(--cognac);"><?= $data['lang'] ?></p>

                <br><br>
                <h3 class="section-title">Recognition</h3>
                <p style="font-size: 0.9rem; line-height: 1.5;"><?= $data['certs'] ?></p>
            </div>
        </div>
    </div>

    <div class="no-print" style="text-align:center; margin-top: 30px; padding-bottom: 50px;">
        <button onclick="window.print()" class="btn-submit">Save as PDF</button>
        <p style="margin-top: 15px;"><a href="" style="color: var(--cognac);">Restart Editor</a></p>
    </div>
    <?php endif; ?>
</div>

</body>
</html>