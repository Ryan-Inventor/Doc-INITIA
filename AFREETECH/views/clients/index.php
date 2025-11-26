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
            <?php if($_SESSION['user_role'] === 'admin'): ?>
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

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-semibold text-slate-900 tracking-tight">Clients</h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Liste des clients rattachés à votre succursale.
                    </p>
                </div>
                <a href="<?php echo url('clients/create'); ?>" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                    Nouveau client
                </a>
            </div>

            <div class="bg-white/80 backdrop-blur rounded-2xl border border-slate-100 shadow-sm">
                <div class="px-4 py-3 border-b border-slate-100 flex items-center justify-between">
                    <h4 class="text-sm font-semibold text-slate-800">Tous les clients</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Nom & Prénom</th>
                                <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Téléphone</th>
                                <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Ville</th>
                                <th class="px-6 py-3 text-left text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Succursale</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-50">
                            <?php foreach ($clients as $client): ?>
                            <tr class="hover:bg-slate-50 cursor-pointer" onclick="window.location='<?php echo url('clients/show/' . $client['id']); ?>'">
                                <td class="px-6 py-4 align-top">
                                    <div class="text-sm font-medium text-slate-900"><?php echo $client['nom'] . ' ' . $client['prenom']; ?></div>
                                    <div class="text-xs text-slate-500 mt-0.5"><?php echo $client['email']; ?></div>
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <div class="text-sm text-slate-900"><?php echo $client['telephone']; ?></div>
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <div class="text-sm text-slate-900"><?php echo $client['ville']; ?></div>
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                        <?php echo $client['succursale_rattachee']; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 align-top text-right whitespace-nowrap">
                                    <a href="<?php echo url('clients/edit/' . $client['id']); ?>" class="text-xs font-medium text-indigo-600 hover:text-indigo-800 mr-3" onclick="event.stopPropagation()">Modifier</a>
                                    <a href="<?php echo url('clients/delete/' . $client['id']); ?>" class="text-xs font-medium text-rose-600 hover:text-rose-800" onclick="event.stopPropagation(); return confirm('Êtes-vous sûr ?')">Supprimer</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
