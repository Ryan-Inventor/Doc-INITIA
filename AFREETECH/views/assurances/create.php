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

            <div>
                <h3 class="text-2xl sm:text-3xl font-semibold text-slate-900 tracking-tight">Nouveau contrat</h3>
                <p class="text-sm text-slate-500 mt-1">
                    Créez un nouveau contrat d'assurance pour un client existant.
                </p>
            </div>

            <div class="bg-white/80 backdrop-blur rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
                <form action="<?php echo url('assurances/create'); ?>" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5" for="client_id">Client</label>
                            <select class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-900 bg-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 outline-none" id="client_id" name="client_id" required>
                                <option value="">Sélectionner un client</option>
                                <?php foreach ($clients as $client): ?>
                                    <option value="<?php echo $client['id']; ?>"><?php echo $client['nom'] . ' ' . $client['prenom'] . ' (' . $client['numero_cni'] . ')'; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5" for="type_assurance">Type d'assurance</label>
                            <select class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-900 bg-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 outline-none" id="type_assurance" name="type_assurance" required>
                                <option value="auto">Auto</option>
                                <option value="habitation">Habitation</option>
                                <option value="sante">Santé</option>
                                <option value="vie">Vie</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5" for="numero_contrat">Numéro de contrat</label>
                            <input class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 outline-none" id="numero_contrat" name="numero_contrat" type="text" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5" for="montant_prime">Montant de la prime</label>
                            <input class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 outline-none" id="montant_prime" name="montant_prime" type="number" step="0.01" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5" for="date_souscription">Date de souscription</label>
                            <input class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 outline-none" id="date_souscription" name="date_souscription" type="date" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5" for="date_expiration">Date d'expiration</label>
                            <input class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 outline-none" id="date_expiration" name="date_expiration" type="date" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5" for="succursale_gestion">Succursale de gestion</label>
                            <select class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-900 bg-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 outline-none" id="succursale_gestion" name="succursale_gestion" required>
                                <option value="douala">Douala</option>
                                <option value="yaounde">Yaoundé</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <button class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1" type="submit">
                            Enregistrer
                        </button>
                        <a href="<?php echo url('assurances'); ?>" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
