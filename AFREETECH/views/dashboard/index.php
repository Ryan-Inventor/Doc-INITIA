<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="min-h-screen flex bg-transparent">
    <!-- Sidebar -->
    <aside class="hidden md:flex md:flex-col w-64 bg-slate-900 text-slate-100 border-r border-slate-800/60">
        <div class="p-5 border-b border-slate-800/60 flex items-center gap-3">
            <div class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-indigo-500/20 text-indigo-300 text-sm font-semibold">
                IN
            </div>
            <div>
                <h1 class="text-lg font-semibold tracking-tight">INTIA</h1>
                <p class="text-xs text-slate-400"><?php echo $_SESSION['user_succursale']; ?></p>
            </div>
        </div>
        <nav class="mt-4 px-2 space-y-1 text-sm">
            <a href="<?php echo url('dashboard'); ?>" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-slate-800 text-slate-100 font-medium">
                <span>Tableau de bord</span>
            </a>
            <a href="<?php echo url('clients'); ?>" class="flex items-center gap-2 px-3 py-2 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                <span>Clients</span>
            </a>
            <a href="<?php echo url('assurances'); ?>" class="flex items-center gap-2 px-3 py-2 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                <span>Assurances</span>
            </a>
            <?php if($_SESSION['user_succursale'] === 'direction'): ?>
            <a href="<?php echo url('utilisateurs'); ?>" class="flex items-center gap-2 px-3 py-2 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                <span>Utilisateurs</span>
            </a>
            <?php endif; ?>
            <div class="pt-4 border-t border-slate-800/60 mt-4">
                <a href="<?php echo url('logout'); ?>" class="flex items-center gap-2 px-3 py-2 rounded-lg text-rose-300 hover:bg-rose-500/10 hover:text-rose-100 transition text-sm">
                    <span>Déconnexion</span>
                </a>
            </div>
        </nav>
    </aside>

    <!-- Content -->
    <div class="flex-1 overflow-x-hidden overflow-y-auto">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
            <!-- Mobile top nav -->
            <div class="md:hidden mb-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-medium uppercase tracking-wide text-slate-500">Navigation</span>
                </div>
                <div class="flex gap-2 overflow-x-auto pb-1">
                    <a href="<?php echo url('dashboard'); ?>" class="whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-medium bg-slate-900 text-white">
                        Dashboard
                    </a>
                    <a href="<?php echo url('clients'); ?>" class="whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-medium bg-white/80 text-slate-700 border border-slate-200">
                        Clients
                    </a>
                    <a href="<?php echo url('assurances'); ?>" class="whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-medium bg-white/80 text-slate-700 border border-slate-200">
                        Assurances
                    </a>
                    <?php if($_SESSION['user_role'] === 'admin'): ?>
                    <a href="<?php echo url('utilisateurs'); ?>" class="whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-medium bg-white/80 text-slate-700 border border-slate-200">
                        Utilisateurs
                    </a>
                    <?php endif; ?>
                    <a href="<?php echo url('logout'); ?>" class="whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-100">
                        Déconnexion
                    </a>
                </div>
            </div>

            <!-- Top bar (titre + succursale) -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-semibold text-slate-900 tracking-tight">Tableau de bord</h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Vue synthétique de votre activité
                        <?php if($succursale === 'direction'): ?>
                            — <span class="font-medium text-slate-700">Direction (toutes succursales)</span>
                        <?php else: ?>
                            — Succursale de <span class="font-medium text-slate-700"><?php echo ucfirst($succursale); ?></span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <!-- Stats cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card Clients -->
                <div class="bg-white/80 backdrop-blur rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
                    <div class="p-3 rounded-xl bg-indigo-500/10 text-indigo-600">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Clients</p>
                        <p class="mt-1 text-2xl font-semibold text-slate-900"><?php echo $totalClients; ?></p>
                        <p class="mt-0.5 text-xs text-slate-400">Clients enregistrés dans votre périmètre</p>
                    </div>
                </div>

                <!-- Card Assurances -->
                <div class="bg-white/80 backdrop-blur rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
                    <div class="p-3 rounded-xl bg-emerald-500/10 text-emerald-600">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Contrats actifs</p>
                        <p class="mt-1 text-2xl font-semibold text-slate-900"><?php echo $totalAssurances; ?></p>
                        <p class="mt-0.5 text-xs text-slate-400">Contrats d'assurance en cours</p>
                    </div>
                </div>

                <!-- Card Revenus -->
                <div class="bg-white/80 backdrop-blur rounded-2xl border border-slate-100 shadow-sm p-5 flex items-center gap-4">
                    <div class="p-3 rounded-xl bg-amber-500/10 text-amber-600">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Revenus (primes)</p>
                        <p class="mt-1 text-2xl font-semibold text-slate-900"><?php echo number_format($totalRevenus, 0, ',', ' '); ?> FCFA</p>
                        <p class="mt-0.5 text-xs text-slate-400">Somme des primes des contrats actifs</p>
                    </div>
                </div>
            </div>

            <!-- Bloc d’intro -->
            <div class="bg-white/80 backdrop-blur rounded-2xl border border-slate-100 shadow-sm p-6">
                <h4 class="text-lg font-semibold text-slate-900 mb-2">Bienvenue sur INTIA Assurance</h4>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Utilisez le menu latéral pour gérer vos clients et contrats d'assurance.
                    <?php if($succursale === 'direction'): ?>
                        Vous disposez d'une vue d'ensemble sur <span class="font-medium">toutes les succursales</span>.
                    <?php else: ?>
                        Vous gérez principalement la succursale de
                        <span class="font-semibold text-slate-800"><?php echo ucfirst($succursale); ?></span>.
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
