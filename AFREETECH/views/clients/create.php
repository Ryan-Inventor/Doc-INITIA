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
            <a href="<?php echo url('clients'); ?>" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-slate-800 text-slate-100 font-medium">
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
                    <a href="<?php echo url('clients'); ?>" class="whitespace-nowrap px-3 py-1.5 rounded-full text-xs font-medium bg-slate-900 text-white">
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

            <div>
                <h3 class="text-2xl sm:text-3xl font-semibold text-slate-900 tracking-tight">Nouveau client</h3>
                <p class="text-sm text-slate-500 mt-1">
                    Renseignez les informations du client à enregistrer.
                </p>
            </div>

            <div class="bg-white/80 backdrop-blur rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">
                <form action="<?php echo url('clients/create'); ?>" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5" for="nom">Nom</label>
                            <input class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 outline-none" id="nom" name="nom" type="text" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5" for="prenom">Prénom</label>
                            <input class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 outline-none" id="prenom" name="prenom" type="text" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5" for="telephone">Téléphone</label>
                            <input class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 outline-none" id="telephone" name="telephone" type="text" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5" for="email">Email</label>
                            <input class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 outline-none" id="email" name="email" type="email">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-1.5" for="adresse">Adresse</label>
                            <textarea class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 outline-none" id="adresse" name="adresse" rows="2"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5" for="ville">Ville</label>
                            <input class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 outline-none" id="ville" name="ville" type="text" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5" for="date_naissance">Date de naissance</label>
                            <input class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 outline-none" id="date_naissance" name="date_naissance" type="date" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5" for="numero_cni">Numéro CNI</label>
                            <input class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 outline-none" id="numero_cni" name="numero_cni" type="text" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5" for="succursale_rattachee">Succursale</label>
                            <select class="block w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm text-slate-900 bg-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 outline-none" id="succursale_rattachee" name="succursale_rattachee" required>
                                <option value="douala">Douala</option>
                                <option value="yaounde">Yaoundé</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <button class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1" type="submit">
                            Enregistrer
                        </button>
                        <a href="<?php echo url('clients'); ?>" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
