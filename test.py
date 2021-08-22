# ----------function--------------

def checkRow(row):
    return 1 in array[row]


def checkColumn(column):
    return 1 in [array[i][column] for i in range(8)]


def checkVertical(row, column):
    # check from top-left to right-bottom
    for i, n in enumerate(range(max(0, row - column), 8)):
        r = max(0, column-row)+i
        if r < 8 and array[n][r] == 1:
            return True

    # check from bottom-left to top-right
    for i, n in enumerate(range(min(7, row + column), -1, -1)):
        r = min(7, max(0, (column+row)-7))+i
        if r < 8 and array[n][r] == 1:
            return True
    return False


def isSafe(row, column):
    return not (checkRow(row) or checkColumn(column) or checkVertical(row, column))


def addQueens(row=0, queens=[]):
    if len(queens) > 6:
        return True
    if row == 8:
        return False
    safePoints = []

    for i in range(8):
        if isSafe(row, i):
            safePoints.append(i)
    for p in safePoints:
        array[row][p] = 1
        if addQueens(row+1, [*queens, (row, p)]):
            return True
        array[row][p] = 0
    return addQueens(row+1, queens)


# ----------start---------------
inx = int(input("X: "))
iny = int(input("Y: "))


# array=[ [0]*8 ]*8

# initialize the array
array = [[0 for j in range(8)] for i in range(8)]

# add the first queen/point
array[iny][inx] = 1

if addQueens():
    # display the output if 6 queens are added
    for row in array:
        print(row, end="\n")
else:
    print("can't add 6 queens")
