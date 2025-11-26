<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="min-h-screen flex items-center justify-center px-4 py-10">
    <div class="max-w-md w-full space-y-8 bg-white/80 backdrop-blur shadow-xl rounded-2xl border border-slate-100 p-8 sm:p-10">
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-indigo-600/10 text-indigo-600">
                <span class="text-xl font-bold">IN</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-semibold text-slate-900">
                INTIA Assurance
            </h2>
            <p class="text-sm text-slate-500">
                Connectez-vous à votre espace de gestion
            </p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-start gap-2" role="alert">
                <span class="mt-0.5">⚠️</span>
                <span class="block sm:inline"><?php echo $error; ?></span>
            </div>
        <?php endif; ?>

        <form class="mt-6 space-y-5" action="<?php echo url('login'); ?>" method="POST">
            <div class="space-y-4">
                <div class="space-y-1.5">
                    <label for="email-address" class="block text-sm font-medium text-slate-700">Adresse email</label>
                    <input
                        id="email-address"
                        name="email"
                        type="email"
                        autocomplete="email"
                        required
                        class="block w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 outline-none transition"
                        placeholder="vous@exemple.com"
                    >
                </div>
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium text-slate-700">Mot de passe</label>
                    </div>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        class="block w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 outline-none transition"
                        placeholder="Votre mot de passe"
                    >
                </div>
            </div>

            <div class="pt-2">
                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center rounded-xl border border-transparent bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1"
                >
                    Se connecter
                </button>
            </div>
        </form>

        <p class="text-[11px] text-center text-slate-400 pt-2">
            INTIA • Plateforme interne de gestion des clients et assurances
        </p>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
