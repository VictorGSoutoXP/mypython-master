from pickle import TRUE
from traceback import print_tb


branco = "A"


def criarBoard():
    board = [
    [branco, branco, branco],
    [branco, branco, branco],
    [branco, branco, branco],
    ]
    return board
    
def printBoard(board):
    for i in range(3):
        print("|".join(board[i]))
        if(i < 2):
            print("------")


def getInputValido(mesangem):
    tpry:
        n = int(input(mensagem))
        if(n>= 1 and n <= 3):
            return n - 1
        else:
            print("Número precisa entrar 1 e 3")
            return getInputValido(mensagem)
        except:
            print("Número não valido")
            return getInputValido(mensagem )


def verificaMovimento(board, 1 , j):
    if(board[i][j] == branco):
        return True
    else:
        return False
    
def fazMovimento(board, i, j, jogador):
    board[i][j] = token [jogador]
    
def verificaGanhador(board):
    return False