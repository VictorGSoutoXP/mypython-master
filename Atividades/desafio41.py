# Crie um programa que leia duas notas de um aluno e calcule sua média. mostrando uma mensagem no final. De acordo com a média atingida: média abaixo de 5.0:REPROVADO média entre 5.0 e 6.9: RECUPERAÇÃO e MÉDIA 7.0 ou superior:APROVADO

nota1 = float(input('Primeira nota: '))
nota2 = float(input('Segunda nota: '))
média = (nota1 + nota2) / 2
print('Tirando {:.1f} e {:.1f}, a média do aluno é {:.1f} '.format(nota1,nota2, média))
if média >=5 and média < 7:
    print('O aluno está de RECUPERAÇÃO.')
elif média < 5:
    print('O aluno está REPROVADO.')
elif média >= 7:
    print('O aluno está APROVADO')