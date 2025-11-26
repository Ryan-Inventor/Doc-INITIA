<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="min-h-screen flex items-center justify-center px-4 py-10">
    <div class="max-w-lg w-full text-center space-y-6 bg-white/80 backdrop-blur rounded-3xl border border-slate-100 shadow-xl p-8 sm:p-10">
        <div class="space-y-2">
            <p class="text-xs font-semibold tracking-[0.2em] text-rose-500 uppercase">Erreur</p>
            <h1 class="text-6xl sm:text-7xl md:text-8xl font-extrabold tracking-tight text-slate-900">404</h1>
            <p class="text-lg sm:text-xl font-medium text-slate-800">Page introuvable</p>
            <p class="text-sm text-slate-500">
                Désolé, la page que vous recherchez n'existe pas ou a été déplacée.
            </p>
        </div>
        <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="<?php echo url('dashboard'); ?>" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                Retour au tableau de bord
            </a>
            <a href="<?php echo url('login'); ?>" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Revenir à la connexion
            </a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
