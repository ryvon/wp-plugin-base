<?php
/**
 * @var \Ryvon\Plugin\Template\RendererInterface $this
 */
?>
<div><?php echo $this->render('message.php', ['message' => $message ?? '']); ?></div>
