<?php require __DIR__ . '/../layouts/header.php'; ?>

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
            <a href="<?php echo url('dashboard'); ?>" class="flex items-center gap-2 px-3 py-2 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                <span>Tableau de bord</span>
            </a>
            <a href="<?php echo url('clients'); ?>" class="flex items-center gap-2 px-3 py-2 rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition">
                <span>Clients</span>
            </a>
            <a href="<?php echo url('assurances'); ?>" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-slate-800 text-slate-100 font-medium">
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
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
            <!-- Mobile top nav -->
            <div class="md:hidden mb-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[11px] font-medium uppercase tracking-wide text-slate-500">Navigation</span>
                </div>
                <div class="flex gap-2 overflow-x-auto pb-1">
                    <a href="<?php echo url('dashboard'); ?>" class="whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-medium bg-white/80 text-slate-700 border border-slate-200">
                        Dashboard
                    </a>
                    <a href="<?php echo url('clients'); ?>" class="whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-medium bg-white/80 text-slate-700 border border-slate-200">
                        Clients
                    </a>
                    <a href="<?php echo url('assurances'); ?>" class="whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-medium bg-slate-900 text-white">
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

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-semibold text-slate-900 tracking-tight">Détails du contrat</h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Informations complètes de ce contrat d'assurance.
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="<?php echo url('assurances/edit/' . $this->assurance->id); ?>" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                        Modifier
                    </a>
                    <a href="<?php echo url('assurances'); ?>" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                        Retour
                    </a>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur rounded-2xl border border-slate-100 shadow-sm">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h3 class="text-lg font-semibold text-slate-900">
                        Contrat n° <?php echo $this->assurance->numero_contrat; ?>
                    </h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Détails du contrat et du client associé.
                    </p>
                </div>
                <div>
                    <dl class="divide-y divide-slate-100">
                        <div class="bg-slate-50/60 px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4">
                            <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">
                                Client
                            </dt>
                            <dd class="text-sm text-slate-900 sm:col-span-2 space-y-0.5">
                                <a href="<?php echo url('clients/show/' . $this->client->id); ?>" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                    <?php echo $this->client->nom . ' ' . $this->client->prenom; ?>
                                </a>
                                <div class="text-xs text-slate-500"><?php echo $this->client->numero_cni; ?></div>
                            </dd>
                        </div>
                        <div class="bg-white px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4">
                            <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">
                                Type d'assurance
                            </dt>
                            <dd class="text-sm text-slate-900 sm:col-span-2">
                                <?php echo ucfirst($this->assurance->type_assurance); ?>
                            </dd>
                        </div>
                        <div class="bg-slate-50/60 px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4">
                            <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">
                                Montant de la prime
                            </dt>
                            <dd class="text-sm text-slate-900 sm:col-span-2">
                                <?php echo number_format($this->assurance->montant_prime, 0, ',', ' '); ?> FCFA
                            </dd>
                        </div>
                        <div class="bg-white px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4">
                            <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">
                                Date de souscription
                            </dt>
                            <dd class="text-sm text-slate-900 sm:col-span-2">
                                <?php echo $this->assurance->date_souscription; ?>
                            </dd>
                        </div>
                        <div class="bg-slate-50/60 px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4">
                            <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">
                                Date d'expiration
                            </dt>
                            <dd class="text-sm text-slate-900 sm:col-span-2">
                                <?php echo $this->assurance->date_expiration; ?>
                            </dd>
                        </div>
                        <div class="bg-white px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4">
                            <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">
                                Statut
                            </dt>
                            <dd class="text-sm text-slate-900 sm:col-span-2">
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium 
                                    <?php echo $this->assurance->statut === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700'; ?>">
                                    <?php echo ucfirst($this->assurance->statut); ?>
                                </span>
                            </dd>
                        </div>
                        <div class="bg-slate-50/60 px-6 py-4 grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4">
                            <dt class="text-xs font-medium text-slate-500 uppercase tracking-wide">
                                Succursale de gestion
                            </dt>
                            <dd class="text-sm text-slate-900 sm:col-span-2">
                                <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                                    <?php echo $this->assurance->succursale_gestion; ?>
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
