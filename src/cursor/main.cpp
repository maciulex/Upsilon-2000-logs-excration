#include <Windows.h>
#include <iostream>
#include <fstream>

int main();
int firstPause = 4000;
int secondPause = 500;

void loadConfig() {
    int lineIterator = 0;
    std::string line;

    std::fstream file;
    file.open("config.txt");
    while (getline(file, line)) {
        switch (lineIterator) {
            case 1:
                try {
                    firstPause = std::stoi(line);
                } catch (...) {
                    return;
                }
            break;
            case 3:
                try {
                    secondPause = std::stoi(line);
                } catch (...) {
                    return;
                }
            break;
        }
        lineIterator += 1;
    }

    file.close();
}

void CIN_FAIL() {
    std::cin.ignore(1000, '\n');
    main();
}

void getCursorPosition() {
    int x;
    while (true) {
        POINT cursor;
        std::cin >> x;
        if (std::cin.fail()) CIN_FAIL();
        if (x == 0) break;
        if (x == 9) Sleep(10000);
        GetCursorPos(&cursor);
        std::cout << std::to_string(cursor.x) << "  " << std::to_string(cursor.y);
    }
}

void inputOneNumber(int x) {
    INPUT ip;
    ip.type = INPUT_KEYBOARD;
    ip.ki.wScan = 0;
    ip.ki.time = 0;
    ip.ki.dwExtraInfo = 0;
    switch (x) {
        case 0:
            ip.ki.wVk = 0x60;
        break;
        case 1:
            ip.ki.wVk = 0x61;
        break;
        case 2:
            ip.ki.wVk = 0x62;
        break;
        case 3:
            ip.ki.wVk = 0x63;
        break;
        case 4:
            ip.ki.wVk = 0x64;
        break;
        case 5:
            ip.ki.wVk = 0x65;
        break;
        case 6:
            ip.ki.wVk = 0x66;
        break;
        case 7:
            ip.ki.wVk = 0x67;
        break;
        case 8:
            ip.ki.wVk = 0x68;
        break;
        case 9:
            ip.ki.wVk = 0x69;
        break;
        default:
            ip.ki.wVk = 0x41;
    }
    ip.ki.dwFlags = 0;
    SendInput(1, &ip, sizeof(INPUT));
    ip.ki.dwFlags = KEYEVENTF_KEYUP;
    SendInput(1, &ip, sizeof(INPUT));
}

void inputNumberString(std::string input) {
    for (int i = 0; i < input.length(); i++) {
        inputOneNumber((int)input[i] - '0');
    }
}

void procedureSave() {
    POINT LogoCursorPos;
    GetCursorPos(&LogoCursorPos);
    int x = LogoCursorPos.x, y = LogoCursorPos.y;

    int saveButton[2], table[2], nextButton[2], saveFileButton[2];

    saveButton[0] = 426; saveButton[1] = 446;
    saveFileButton[0] = 455; saveFileButton[1] = 343;
    table[0] = 106; table[1] = 311;
    nextButton[0] = 175; nextButton[1] = 341;

    int times;
    std::cout << "How many pages to get\n";
    std::cin >> times;
    if (std::cin.fail()) CIN_FAIL();

    for (int i = 0; i < times; i++) {
        Sleep(firstPause);
        SetCursorPos(x+saveButton[0], y+saveButton[1]);
        mouse_event(MOUSEEVENTF_LEFTDOWN | MOUSEEVENTF_LEFTUP, 0, 0, 0, 0);
        Sleep(secondPause);
        inputNumberString(std::to_string(i));
        SetCursorPos(x+saveFileButton[0], y+saveFileButton[1]);
        Sleep(secondPause);
        mouse_event(MOUSEEVENTF_LEFTDOWN | MOUSEEVENTF_LEFTUP, 0, 0, 0, 0);

        Sleep(secondPause);

        SetCursorPos(x+table[0], y+table[1]);
        mouse_event(MOUSEEVENTF_RIGHTDOWN | MOUSEEVENTF_RIGHTUP, 0, 0, 0, 0);

        Sleep(secondPause);

        SetCursorPos(x+nextButton[0], y+nextButton[1]);
        mouse_event(MOUSEEVENTF_LEFTDOWN | MOUSEEVENTF_LEFTUP, 0, 0, 0, 0);
    }


}

int main()
{
    loadConfig();
    mainStart:
    int choice;
    std::cout
    << "------Menu------\n"
    << "1) procedure save\n"
    << "2) getCursorPos\n"
    << "9) exit\n"
    << "\n";
    std::cin >> choice;
    if (std::cin.fail()) CIN_FAIL();
    switch (choice) {
        case 1:
            procedureSave();
        break;
        case 2:
            getCursorPosition();
        break;
        case 9:
            return 0;
    }
    goto mainStart;

    return 0;
}
