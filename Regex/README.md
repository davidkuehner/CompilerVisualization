# Visualiser un compilateur

Les compilateurs sont des outils formidables qui rendent beaucoup de services.
Toutefois, il peut vite devenir difficile de visualiser les données qu'ils
manipulent en entrée ou en sortie. L'objectif de ce sujet est double : dans un
premier temps, nous proposons de réaliser une représentation graphique d'une
expression régulière, puis dans un second temps, optionnellement, d'étendre les
compétences fraîchement acquises pour réaliser une représentation graphique
d'une grammaire algébrique.

# Utilisation

Si Hoa est installé dans `/usr/local/lib/Hoa`, les Hoathis doivent être
installées au même niveau, c'est à dire dans `/usr/local/lib/Hoathis`. Cette
bibliothèque est une Hoathis de
[`Hoa\Regex`](https://github.com/hoaproject/Regex). Voici comment l'installer
facilement (sans passer par Composer) :

    $ git clone http://git.hoa-project.net/Central.git \
                /usr/local/lib/Hoa.central
    $ ln -s /usr/local/lib/Hoa.central/Hoa \
            /usr/local/lib/Hoa
    $ ln -s /usr/local/lib/Hoa.central/Hoathis \
            /usr/local/lib/Hoathis
    $ git clone https://github.com/davidkuhner/compiler-visualization \
                /usr/local/lib/Hoathis/Regex

Placer le script `hoa` (dans `/usr/local/lib/Hoa/Core/Bin/`) dans `$PATH`.
Ensuite, nous pourrons utiliser `hoa compiler:pp`. Cette commande prend une
grammaire et une donnée en entrée, et analyse cette donnée par rapport à cette
grammaire. Elle produit un AST, et nous sommes ensuite capable d'y appliquer un
visiteur à l'aide des options `--visitor dump` ou `--visitor-class …`. Pour
rappel, voici le schéma du processus.

À partir d'une grammaire et d'une regex (notre donnée), le compilateur nous
produit un AST. Nous appliquons un visiteur sur cet AST pour nous produire du
(le transformer en) SVG. Ainsi :

                                     +---------+
    +-----------+                    | visitor |
    | grammaire |---------+          +---------+
    +-----------+         |               |
                          v               v
      +-------+      +----------+      +-----+
      | regex | ---> | compiler | ---> | AST |
      +-------+      +----------+      +-----+
                                          |
                                          v
                                      +-------+
                                      | <svg> |
                                      +-------+

Premier exemple, nous allons *dumper* l'AST :

    $ echo '[a-z]+' | \
          hoa compiler:pp --visitor dump hoa://Library/Regex/Grammar.pp 0
    >  #expression
    >  >  #quantification
    >  >  >  #class
    >  >  >  >  #range
    >  >  >  >  >  token(literal, a)
    >  >  >  >  >  token(literal, z)
    >  >  >  token(one_or_more, +)

Et maintenant, nous appliquons notre propre visiteur
`Hoathis\Regex\Visitor\Visualization` :

    $ echo '[a-z]+' | \
          hoa compiler:pp \
              --visitor-class Hoathis.Regex.Visitor.Visualization \
              hoa://Library/Regex/Grammar.pp \
              0

À toi de jouer !
