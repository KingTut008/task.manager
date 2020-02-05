<ul class="<?= $ulClass; ?>">
    <?php foreach ($menuItems as $menuItem): ?>
        <li><a class="<?= checkUrl($menuItem['path']) ? 'main-menu-active' : ''; ?>" href="<?= $menuItem['path']; ?>"><?= menuShort($menuItem['title']); ?></a></li>
    <?php endforeach; ?>
</ul>