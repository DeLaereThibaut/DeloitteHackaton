

<div id="StatChart_1"></div>
<?= \Lava::render('PieChart', 'StatChart_1', 'StatChart_1') ?>
<div id="StatChart_2"></div>
<?= \Lava::render('PieChart', 'StatChart_2', 'StatChart_2') ?>
<div id="StatChart_4"></div>
<?= \Lava::render('PieChart', 'StatChart_4', 'StatChart_4') ?>
<div id="StatChart_3"></div>
<?= \Lava::render('PieChart', 'StatChart_3', 'StatChart_3') ?>
<div>
    Number of School: {{\App\Models\School::all()->count()}}
</div>
<div>
    Number of Events:{{\App\Models\SchoolEvent::all()->count()}}
</div>
<div>
    Number of Students:{{\App\Models\Student::all()->count()}}
</div>
