<?php $this->layout('site::layout', array('title' => 'General Page')); ?>

<!-- $this->e() is just a way of escaping variables so that the content printed is HTML friendly -->
<h1>Hello, <?=$this->e($name)?>!</h1>

<p>How are you today?</p>
