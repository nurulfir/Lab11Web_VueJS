<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= $title; ?></title>
  <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-HNIR+...+Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <div id="container">
    <header>
      <h1>Portal Berita</h1>
      <p class="tagline">Sumber informasi terkini dan terpercaya</p>
    </header>
    <nav>
      <a href="<?= base_url('/'); ?>">Home</a>
      <a href="<?= base_url('/artikel'); ?>">Artikel</a>
      <a href="<?= base_url('/about'); ?>">About</a>
      <a href="<?= base_url('/contact'); ?>">Kontak</a>
      <a href="<?= base_url('admin/artikel'); ?>">Dashboard Admin</a>
    </nav>
    <section id="wrapper">
      <section id="main">