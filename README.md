# Gerador de Currículo

> APO — Fundamentos de Programação para Internet · UNIPAR ADS

## 📋 Descrição

Aplicação web desenvolvida como Atividade Prática Orientada (APO) da disciplina **Fundamentos de Programação para Internet** do curso de **Análise e Desenvolvimento de Sistemas** da UNIPAR.

O sistema permite ao usuário criar um currículo profissional preenchendo um formulário direto no navegador, e gerar o documento pronto para impressão ou download em PDF.

---

## ⚙️ Tecnologias Utilizadas

| Camada     | Tecnologia                      |
|------------|----------------------------------|
| Backend    | PHP                              |
| Frontend   | HTML5, CSS3, JavaScript          |
| Framework  | Bootstrap 5                      |
| Dev Server | XAMPP (Apache + PHP)             |
| Versionamento | Git + GitHub                  |

---

## 🗂️ Estrutura do Projeto

```
gerador-de-curriculo/
├── curriculo.php     # Formulário + backend + currículo gerado (tudo em um arquivo)
└── README.md
```

---

## 🚀 Como Executar Localmente

### Pré-requisitos
- [XAMPP](https://www.apachefriends.org/pt_br/index.html) instalado

### Passos

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/gustavo2978/gerador-de-curriculo.git
   ```

2. **Mova a pasta para o XAMPP:**
   ```
   C:\xampp\htdocs\gerador-de-curriculo\
   ```

3. **Inicie o Apache** pelo painel do XAMPP.

4. **Acesse no navegador:**
   ```
   http://localhost/gerador-de-curriculo/curriculo.php
   ```

---

## ✨ Funcionalidades

- **Formulário único** com dados pessoais, resumo profissional, experiências, formação, habilidades, idiomas e referências
- **Cálculo automático de idade** via JavaScript ao selecionar a data de nascimento
- **Campos dinâmicos** — botão `+` para adicionar experiências, formações e referências sem recarregar a página
- **Geração do currículo formatado** feita pelo backend PHP (`$_POST`, `htmlspecialchars`, `foreach`)
- **Impressão / Download em PDF** via `window.print()` com regras CSS `@media print`
- **Layout responsivo** com Bootstrap 5


