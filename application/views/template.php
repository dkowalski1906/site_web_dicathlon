<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>validation reservation</title>
    <link rel="stylesheet" href="'.base_url().'CSS/index.css">
    <link rel="stylesheet" href="'.base_url().'CSS/create-account.css">
    <link rel="stylesheet" href="'.base_url().'CSS/product.css">
    <link rel="stylesheet" href="'.base_url().'CSS/style.css">
    <link rel="stylesheet" href="'.base_url().'CSS/valid-reservation.css">
</head>
<body>
        <div id="global">
           
            <div id="contenu">
                <?php $this->load->view('header');?>
                <?php $this->load->view($content);?>
            </div>
            <?php $this->load->view('footer');?>
        </div>
    
    </body>
</html>