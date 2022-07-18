<?php $v->layout("_theme"); ?>

<section class="dash_content_app">
    <?php if (!$user) : ?>
        <header class="dash_content_app_header">
            <h2 class="icon-plus-circle">Novo Usuário</h2>
        </header>

        <div class="dash_content_app_box">
            <form class="app_form" action="<?= url("/app/usuarios/usuario"); ?>" method="post">
                <!--ACTION SPOOFING-->
                <input type="hidden" name="action" value="create" />

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">*Nome:</span>
                        <input type="text" name="first_name" placeholder="Primeiro nome" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Sobrenome:</span>
                        <input type="text" name="last_name" placeholder="Último nome" required />
                    </label>
                </div>

                <label class="label">
                    <span class="legend">Genero:</span>
                    <select name="genre">
                        <option value="male">Masculino</option>
                        <option value="female">Feminino</option>
                        <option value="other">Outros</option>
                    </select>
                </label>

                <label class="label">
                    <span class="legend">Foto: (600x600px)</span>
                    <input type="file" name="photo" />
                </label>

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">Nascimento:</span>
                        <input type="text" class="mask-date" name="datebirth" placeholder="dd/mm/aaaa" maxlength="10" />
                    </label>

                    <label class="label">
                        <span class="legend">Documento:</span>
                        <input class="mask-doc" type="text" name="document" placeholder="CPF do usuário" />
                    </label>
                </div>

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">*E-mail:</span>
                        <input type="email" name="email" placeholder="Melhor e-mail" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Senha:</span>
                        <input type="password" name="password" placeholder="Senha de acesso" required />
                    </label>
                </div>

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">*Level:</span>
                        <select name="level" required>
                            <option value="1">Usuário</option>
                            <option value="5">Admin</option>
                        </select>
                    </label>

                    <label class="label">
                        <span class="legend">*Status:</span>
                        <select name="status" required>
                            <option value="registered">Registrado</option>
                            <option value="confirmed">Confirmado</option>
                        </select>
                    </label>
                </div>

                <div class="label_g2">
                    <label class="label">
                        <span class="field icon-briefcase">Empresa:</span>
                        <select name="wallet">
                            <?php foreach ($wallets as $wallet) : ?>
                                <option value="<?= $wallet->id; ?>">&ofcir; <?= $wallet->wallet; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>


                <div class="al-right">
                    <button class="btn btn-green icon-check-square-o">Criar Usuário</button>
                </div>
            </form>
        </div>
    <?php else : ?>
        <header class="dash_content_app_header">
            <h2 class="icon-user"><?= $user->fullName(); ?></h2>
        </header>

        <div class="dash_content_app_box">
            <form class="app_form" action="<?= url("/app/usuarios/usuario/{$user->id}"); ?>" method="post">
                <!--ACTION SPOOFING-->
                <input type="hidden" name="action" value="update" />

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">*Nome:</span>
                        <input type="text" name="first_name" value="<?= $user->first_name; ?>" placeholder="Primeiro nome" required />
                    </label>

                    <label class="label">
                        <span class="legend">*Sobrenome:</span>
                        <input type="text" name="last_name" value="<?= $user->last_name; ?>" placeholder="Último nome" required />
                    </label>
                </div>

                <label class="label">
                    <span class="legend">Gênero:</span>
                    <select name="genre">
                        <?php
                        $genre = $user->genre;
                        $select = function ($value) use ($genre) {
                            return ($genre == $value ? "selected" : "");
                        };
                        ?>
                        <option <?= $select("male"); ?> value="male">Masculino</option>
                        <option <?= $select("female"); ?> value="female">Feminino</option>
                        <option <?= $select("other"); ?> value="other">Outros</option>
                    </select>
                </label>

                <label class="label">
                    <span class="legend">Foto: (600x600px)</span>
                    <input type="file" name="photo" />
                </label>

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">Nascimento:</span>
                        <input type="text" class="mask-date" value="<?= date_fmt($user->datebirth, "d/m/Y"); ?>" name="datebirth" placeholder="dd/mm/aaaa" maxlength="10" />
                    </label>

                    <label class="label">
                        <span class="legend">Documento:</span>
                        <input class="mask-doc" type="text" value="<?= $user->document; ?>" name="document" placeholder="CPF do usuário" />
                    </label>
                </div>

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">*E-mail:</span>
                        <input type="email" name="email" value="<?= $user->email; ?>" placeholder="Melhor e-mail" required />
                    </label>

                    <label class="label">
                        <span class="legend">Alterar Senha:</span>
                        <input type="password" name="password" placeholder="Senha de acesso" />
                    </label>
                </div>

                <div class="label_g2">
                    <label class="label">
                        <span class="legend">*Level:</span>
                        <select name="level" required>
                            <option value="1" <?= $user->level == 1 ? 'selected' : ''; ?>>Usuário</option>
                            <option value="5" <?= $user->level == 5 ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </label>

                    <label class="label">
                        <span class="legend">*Status:</span>
                        <select name="status" required>
                            <option value="registered">Registrado</option>
                            <option value="confirmed">Confirmado</option>
                        </select>
                    </label>

                </div>

                <div class="label_g2">
                    <label class="label">
                        <span class="field icon-briefcase">Empresa:</span>
                        <select name="wallet">
                            <?php foreach ($wallets as $wallet) : ?>
                                <option <?= ($wallet->user_id == $user->id ? "selected" : ""); ?> value="<?= $wallet->id; ?>">&ofcir; <?= $wallet->wallet; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>

                <div class="app_form_footer">
                    <button class="btn btn-blue icon-check-square-o">Atualizar</button>
                    <a href="#" class="remove_link icon-warning" data-post="<?= url("/app/usuarios/usuario/{$user->id}"); ?>" data-action="delete" data-confirm="ATENÇÃO: Tem certeza que deseja excluir o usuário e todos os dados relacionados a ele? Essa ação não pode ser desfeita!" data-user_id="<?= $user->id; ?>">Excluir Usuário</a>
                </div>
            </form>
        </div>
    <?php endif; ?>
</section>