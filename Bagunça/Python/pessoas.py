class pessoa:
    def __init__(self, nome, idade, cpf):
        self.nome = nome
        self.idade = idade
        self.cpf = cpf
     


pessoas = [
    pessoa(nome="Gabriela", idade=22, cpf=12332112332),
    pessoa(nome="Beatriz", idade=20, cpf=12332112332),
    pessoa(nome="Júlia", idade=24, cpf=12332112332),
    
]

pessoas_ordenado = sorted(pessoas, key=lambda obj: obj.nome)

for pessoa in pessoas_ordenado:
    print(f"{pessoa.nome} tem {pessoa.idade} anos e seu CPF é  {pessoa.cpf} Fim.")


